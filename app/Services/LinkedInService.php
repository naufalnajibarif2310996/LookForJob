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
        ])->post($url, [
            'search_term' => $keyword,
            'location' => $location,
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