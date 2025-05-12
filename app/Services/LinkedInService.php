<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkedInService
{
    public function getJobs($keyword, $location)
    {
        $url = 'https://jobs-search-api.p.rapidapi.com/getjobs';
        Log::info('Fetching jobs from URL:', ['url' => $url]);

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
            'X-RapidAPI-Host' => env('RAPIDAPI_HOST'),
            'Content-Type' => 'application/json',
        ])->retry(3, 1000) // Retry 3 kali jika gagal
        ->timeout(60) // Timeout 60 detik
        ->post($url, [
            'search_term' => $keyword,
            'location' => $location,
            // Hapus atau atur nilai besar untuk results_wanted
            'results_wanted' => 1000, // Atur nilai besar jika diperlukan
            'site_name' => ['indeed', 'linkedin', 'glassdoor'],
            'distance' => 50,
            'job_type' => 'fulltime',
            'is_remote' => false,
            'linkedin_fetch_description' => false,
            'hours_old' => 72,
        ]);

        if ($response->failed()) {
            Log::error('API Error:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \Exception('Failed to fetch jobs from API. Status: ' . $response->status());
        }

        Log::info('API Response:', ['data' => $response->json()]);

        return $response->json();
    }
}