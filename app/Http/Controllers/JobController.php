<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->query('keyword', '');
        $location = $request->query('location', '');
        $searchPerformed = $request->has('keyword') || $request->has('location');
        $jobs = [];
        $error = null;

        if ($searchPerformed) {
            try {
                $response = \Illuminate\Support\Facades\Http::get('http://127.0.0.1:5000/api/jobs', [
                    'q' => $keyword,
                    'l' => $location,
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['error'])) {
                        $error = $data['error'];
                    } else {
                        $jobs = array_map(function ($item) {
                            return [
                                'judul' => $item['judul'] ?? '',
                                'link' => $item['link'] ?? '',
                                'perusahaan' => $item['perusahaan'] ?? '',
                                'logo' => $item['logo'] ?? '',
                                'lokasi' => $item['lokasi'] ?? '',
                                'gaji' => $item['gaji'] ?? '',
                                'dipost' => $item['dipost'] ?? '',
                            ];
                        }, $data);
                    }
                } else {
                    $error = 'Gagal mengambil data dari API. Status code: ' . $response->status();
                }
            } catch (\Exception $e) {
                $error = 'Terjadi kesalahan: ' . $e->getMessage();
            }
        }

        return view('jobs.index', [
            'jobs' => $jobs,
            'keyword' => $keyword,
            'location' => $location,
            'searchPerformed' => $searchPerformed,
            'error' => $error
        ]);
    }

    public function showDetail(Request $request)
    {
        $url = $request->query('url');
        if (!$url) abort(404);

        try {
            $client = new Client(['verify' => false]);
            $response = $client->get($url, [
                'headers' => [ 'User-Agent' => 'Mozilla/5.0' ]
            ]);
            $html = (string)$response->getBody();
            $crawler = new Crawler($html);

            // Judul
            $judul = $crawler->filter('h1[data-automation="job-detail-title"]')->count()
                ? $crawler->filter('h1[data-automation="job-detail-title"]')->text()
                : '';

            // Perusahaan
            $perusahaan = $crawler->filter('span[data-automation="advertiser-name"]')->count()
                ? $crawler->filter('span[data-automation="advertiser-name"]')->text()
                : '';

            // Lokasi (opsional, ganti selector jika perlu)
            $lokasi = $crawler->filter('span[data-automation="job-detail-location"]')->count()
                ? $crawler->filter('span[data-automation="job-detail-location"]')->text()
                : '';

            // Gaji (opsional, ganti selector jika perlu)
            $gaji = $crawler->filter('span[data-automation="job-detail-salary"]')->count()
                ? $crawler->filter('span[data-automation="job-detail-salary"]')->text()
                : '';

            // Dipost (opsional, ganti selector jika perlu)
            $dipost = $crawler->filter('span[data-automation="jobListingDate"]')->count()
                ? $crawler->filter('span[data-automation="jobListingDate"]')->text()
                : '';

            // Deskripsi
            $deskripsi = $crawler->filter('div[data-automation="jobAdDetails"]')->count()
                ? $crawler->filter('div[data-automation="jobAdDetails"]')->html()
                : '';

            // Tombol Lamar
            $lamarElement = $crawler->filter('a[data-automation="job-detail-apply"]')->first();
            $lamar_url = $lamarElement->count() ? $lamarElement->attr('href') : null;
            if ($lamar_url && str_starts_with($lamar_url, '/')) {
                $parsedUrl = parse_url($url);
                $lamar_url = $parsedUrl['scheme'].'://'.$parsedUrl['host'].$lamar_url;
            }

            return view('jobs.detail', [
                'judul' => $judul,
                'perusahaan' => $perusahaan,
                'lokasi' => $lokasi,
                'gaji' => $gaji,
                'dipost' => $dipost,
                'deskripsi' => $deskripsi,
                'lamar_url' => $lamar_url,
                'url' => $url
            ]);
        } catch (\Exception $e) {
            abort(404, 'Gagal mengambil detail lowongan.');
        }
    }
}