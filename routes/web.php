<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Services\LinkedInService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\JobFrontendController;

// Route untuk halaman utama
Route::get('/', function () {
    return view('home');
});

// Route untuk dashboard (dengan middleware autentikasi)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route untuk mendapatkan pekerjaan (dengan middleware autentikasi)
Route::middleware(['auth'])->group(function () {
    Route::get('/jobs', [JobController::class, 'getJobs']);
});

// Route untuk mendapatkan profil LinkedIn
Route::get('/api/linkedin-profile', function (Request $request, LinkedInService $linkedInService) {
    $request->validate([
        'username' => 'required|string',
    ]);

    try {
        $data = $linkedInService->getProfileTopPosition($request->input('username'));

        // Format ulang data profil
        $headquarter = $data['data']['headquarter'] ?? [];
        $formattedData = [
            'name' => $data['data']['name'] ?? 'N/A',
            'position' => $data['data']['position'] ?? 'N/A',
            'company' => $data['data']['company'] ?? 'N/A',
            'location' => $headquarter['city'] . ', ' . ($headquarter['country'] ?? 'N/A'),
        ];

        return response()->json($formattedData);
    } catch (\Exception $e) {
        Log::error('Error fetching LinkedIn profile:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Route untuk mendapatkan pekerjaan dari LinkedIn
Route::get('/api/linkedin-jobs', function (Request $request, LinkedInService $linkedInService) {
    $request->validate([
        'keyword' => 'required|string',
        'location' => 'required|string',
    ]);

    try {
        $data = $linkedInService->getJobs($request->input('keyword'), $request->input('location'));

        // Format ulang data pekerjaan
        $formattedJobs = collect($data['data']['jobs'] ?? [])->map(function ($job) {
            return [
                'title' => $job['title'] ?? 'N/A',
                'company' => $job['company'] ?? 'N/A',
                'location' => $job['location'] ?? 'N/A',
                'description' => $job['description'] ?? 'N/A',
                'url' => $job['url'] ?? 'N/A',
            ];
        });

        return response()->json($formattedJobs);
    } catch (\Exception $e) {
        Log::error('Error fetching LinkedIn jobs:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Route untuk mendapatkan pekerjaan dari API umum
Route::get('/api/jobs', function (Request $request, LinkedInService $linkedInService) {
    $request->validate([
        'keyword' => 'required|string',
        'location' => 'required|string',
    ]);

    try {
        $data = $linkedInService->getJobs($request->input('keyword'), $request->input('location'));

        // Format ulang data pekerjaan
        $formattedJobs = collect($data['jobs'] ?? [])->map(function ($job) {
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

        return response()->json($formattedJobs, 200, [], JSON_PRETTY_PRINT);
    } catch (\Exception $e) {
        Log::error('Error fetching jobs:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Route untuk halaman pekerjaan frontend
Route::get('/jobs/frontend', [JobFrontendController::class, 'index']);