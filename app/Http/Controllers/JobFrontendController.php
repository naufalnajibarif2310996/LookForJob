<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LinkedInService;

class JobFrontendController extends Controller
{
    public function index(Request $request, LinkedInService $linkedInService)
    {
        $keyword = $request->input('keyword', 'developer');
        $location = $request->input('location', 'indonesia');

        try {
            $data = $linkedInService->getJobs($keyword, $location);

            // Format ulang data pekerjaan
            $jobs = collect($data['jobs'] ?? [])->map(function ($job) {
                return [
                    'id' => $job['id'] ?? 'N/A',
                    'title' => $job['title'] ?? 'N/A',
                    'company' => $job['company'] ?? 'N/A',
                    'location' => $job['location'] ?? 'N/A',
                    'date_posted' => $job['date_posted'] ?? 'N/A',
                    'url' => $job['job_url'] ?? 'N/A',
                    'company_url' => $job['company_url'] ?? 'N/A',
                    'description' => $job['description'] ?? 'N/A',
                    'is_remote' => $job['is_remote'] ?? 'N/A',
                ];
            });

            return view('jobs.index', compact('jobs', 'keyword', 'location'));
        } catch (\Exception $e) {
            return view('jobs.index', [
                'jobs' => [],
                'error' => $e->getMessage(),
                'keyword' => $keyword,
                'location' => $location,
            ]);
        }
    }
}
