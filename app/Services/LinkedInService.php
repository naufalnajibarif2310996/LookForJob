<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInService
{
    protected $baseUrl;

    public function __construct()
    {
        // Bisa ambil base_url dari env (bisa ganti-ganti tanpa ubah kode)
        $this->baseUrl = config('services.jobapi.base_url', 'http://127.0.0.1:5000');
    }

    /**
     * Ambil daftar pekerjaan dari API Flask.
     * Hasil array tiap item minimal punya key 'judul' dan 'link'.
     *
     * @param string $keyword
     * @param string $location
     * @return array
     * @throws \Exception
     */
    public function getJobs($keyword, $location)
    {
        try {
            $response = Http::get($this->baseUrl . '/api/jobs', [
                'q' => $keyword,
                'l' => $location,
            ]);

            if ($response->failed()) {
                Log::error('API Flask Error:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception('Failed to fetch jobs from Flask API. Status: ' . $response->status());
            }

            $data = $response->json();

            // Pastikan hasil array of jobs, dan tiap item minimal ada 'judul' dan 'link'
            if (is_array($data)) {
                return array_map(function ($item) {
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

            // Jika API mengembalikan error berbentuk array
            if (isset($data['error'])) {
                throw new \Exception($data['error']);
            }

            // Jika data tidak sesuai harapan
            return [];
        } catch (\Exception $e) {
            Log::error('Exception in LinkedInService@getJobs: ' . $e->getMessage());
            throw $e;
        }
    }
}