<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto mt-10 p-4 bg-white shadow rounded">
        <h1 class="text-2xl font-bold mb-4">Job Listings</h1>
        <form method="GET" action="{{ url('/jobs') }}" class="mb-6">
            <div class="flex flex-wrap gap-2">
                <input type="text" name="keyword" class="flex-1 px-3 py-2 border border-gray-300 rounded" placeholder="Keyword (e.g., developer)" value="{{ $keyword ?? '' }}">
                <input type="text" name="location" class="flex-1 px-3 py-2 border border-gray-300 rounded" placeholder="Location (e.g., indonesia)" value="{{ $location ?? '' }}">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
            </div>
        </form>
        @if (isset($error))
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ $error }}
            </div>
        @endif
        @if (!empty($jobs) && count($jobs) > 0)
            <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Company</th>
                        <th class="px-4 py-2 border">Location</th>
                        <th class="px-4 py-2 border">Date Posted</th>
                        <th class="px-4 py-2 border">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td class="px-4 py-2 border">{{ ($jobs->currentPage() - 1) * $jobs->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $job['title'] ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $job['company'] ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $job['location'] ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $job['date_posted'] ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                @if(!empty($job['job_url']))
                                    <a href="{{ $job['job_url'] }}" target="_blank" class="inline-block px-3 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-700">View</a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="mt-6 flex justify-center">
                {{ $jobs->withQueryString()->links('pagination::tailwind') }}
            </div>
        @else
            @if ($searchPerformed)
                <p class="text-gray-600">No jobs found. Try searching with different keywords or location.</p>
            @else
                <p class="text-gray-600">Masukkan keyword dan lokasi, lalu klik Search untuk melihat daftar pekerjaan.</p>
            @endif
        @endif
    </div>
</body>
</html>