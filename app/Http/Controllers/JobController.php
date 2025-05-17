<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobScraper;
use Illuminate\Pagination\LengthAwarePaginator;

class JobController extends Controller
{
    public function getJobs(Request $request, JobScraper $scraper)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $keyword = $request->query('keyword');
        $location = $request->query('location');
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);

        try {
            $jobs = $scraper->scrapeIndeed($keyword, $location);

            $paginatedJobs = new LengthAwarePaginator(
                array_slice($jobs, ($page - 1) * $perPage, $perPage),
                count($jobs),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            return response()->json($paginatedJobs);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
