<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\JobController;
use App\Http\Controllers\JobFrontendController;
use App\Http\Controllers\CVController;
use App\Services\LinkedInService;
use App\Http\Controllers\auth\RegisteredUserController;
use App\Http\Controllers\ProfileController; // Tambah untuk route profile

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di bawah ini adalah semua route untuk aplikasi Job & CV Helper.
|
*/

// Route halaman utama
Route::get('/', function () {
    return view('home');
})->name('home');

// Route halaman daftar pekerjaan (frontend, dengan pagination & pencarian)
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

// Route halaman CV
Route::get('/cv', function () {
    return view('cv');
});

// Route register custom (override Jetstream/Fortify register)
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest'])
    ->name('register');

// Route halaman profile (hanya untuk user yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

// Route API - Ambil profil LinkedIn
Route::get('/api/linkedin-profile', function (Request $request, LinkedInService $linkedInService) {
    $request->validate([
        'username' => 'required|string',
    ]);

    try {
        $data = $linkedInService->getProfileTopPosition($request->input('username'));

        $headquarter = $data['data']['headquarter'] ?? [];
        $formattedData = [
            'name' => $data['data']['name'] ?? 'N/A',
            'position' => $data['data']['position'] ?? 'N/A',
            'company' => $data['data']['company'] ?? 'N/A',
            'location' => ($headquarter['city'] ?? 'Unknown') . ', ' . ($headquarter['country'] ?? 'N/A'),
        ];

        return response()->json($formattedData);
    } catch (\Exception $e) {
        Log::error('Error fetching LinkedIn profile:', ['error' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Route API - Ambil pekerjaan dari LinkedIn
Route::get('/api/linkedin-jobs', function (Request $request, LinkedInService $linkedInService) {
    $request->validate([
        'keyword' => 'required|string',
        'location' => 'required|string',
    ]);

    try {
        $data = $linkedInService->getJobs($request->input('keyword'), $request->input('location'));

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

// Route API - Ambil pekerjaan dari API umum
Route::get('/api/jobs', function (Request $request, LinkedInService $linkedInService) {
    $request->validate([
        'keyword' => 'required|string',
        'location' => 'required|string',
    ]);

    try {
        $data = $linkedInService->getJobs($request->input('keyword'), $request->input('location'));

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

// Route API - Generate CV dari input user
Route::post('/api/generate-cv', [CVController::class, 'create']);
