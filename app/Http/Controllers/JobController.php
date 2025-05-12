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
            'page' => 'integer|min:1',
            'per_page' => 'integer|min:1|max:50',
        ]);

        $keyword = $request->input('keyword');
        $location = $request->input('location');
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

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
