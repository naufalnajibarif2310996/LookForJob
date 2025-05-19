<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInService
{
    public function getJobs($keyword, $location, $page = 1, $perPage = 10)
    {
        $url = 'https://jobs-search-api.p.rapidapi.com/getjobs';

        // Hitung offset (mulai dari data ke-berapa)
        $offset = ($page - 1) * $perPage;

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
            'X-RapidAPI-Host' => env('RAPIDAPI_HOST'),
            'Content-Type' => 'application/json',
        ])->post($url, [
            'search_term' => $keyword,
            'location' => $location,
            'results_wanted' => $perPage,
            'offset' => $offset,
            // tambahkan parameter lain sesuai kebutuhan, misal site_name, job_type, dst.
        ]);

        if ($response->failed()) {
            Log::error('API Error:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \Exception('Failed to fetch jobs from API. Status: ' . $response->status());
        }

        return $response->json();
    }
}