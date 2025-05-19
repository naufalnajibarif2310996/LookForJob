<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LinkedInService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class JobController extends Controller
{
    protected $linkedInService;

    public function __construct(LinkedInService $linkedInService)
    {
        $this->linkedInService = $linkedInService;
    }

    public function index(Request $request)
    {
        $keyword = $request->query('keyword', '');
        $location = $request->query('location', '');
        $page = max(1, (int)$request->query('page', 1));
        $perPage = 10;
        $maxPage = 5;
        $searchPerformed = $request->has('keyword') || $request->has('location');
        $jobs = [];
        $totalJobs = 0;
        $error = null;

        // Jika user paksa ke halaman > 5, tampilkan error dan kunci di halaman 5
        if ($page > $maxPage) {
            $error = 'Maksimal hanya bisa melihat sampai halaman 5 (50 data) karena batasan API.';
            $jobs = [];
            $totalJobsLimited = $perPage * $maxPage;
            $paginator = new LengthAwarePaginator(
                $jobs,
                $totalJobsLimited,
                $perPage,
                $maxPage, // paksa kembali ke halaman 5
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
            return view('jobs.index', [
                'jobs' => $paginator,
                'keyword' => $keyword,
                'location' => $location,
                'searchPerformed' => $searchPerformed,
                'error' => $error,
            ]);
        }

        if ($searchPerformed) {
            try {
                $cacheKey = "jobs_{$keyword}_{$location}_{$page}";
                $data = Cache::remember($cacheKey, 300, function () use ($keyword, $location, $page, $perPage) {
                    return $this->linkedInService->getJobs($keyword, $location, $page, $perPage);
                });
                $jobs = $data['jobs'] ?? [];
                $totalJobs = $data['total_jobs'] ?? ($page * $perPage + count($jobs));
            } catch (\Exception $e) {
                if (str_contains($e->getMessage(), '429')) {
                    $error = 'Batas pencarian API sudah tercapai. Silakan coba lagi nanti.';
                } else {
                    $error = $e->getMessage();
                }
            }
        }

        // Batasi maksimal 5 halaman
        $maxTotal = $perPage * $maxPage;
        $totalJobsLimited = min($totalJobs, $maxTotal);

        $paginator = new LengthAwarePaginator(
            $jobs,
            $totalJobsLimited,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('jobs.index', [
            'jobs' => $paginator,
            'keyword' => $keyword,
            'location' => $location,
            'searchPerformed' => $searchPerformed,
            'error' => $error,
        ]);
    }
}