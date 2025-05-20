<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto mt-10 p-4 bg-white shadow rounded">
        <h1 class="text-2xl font-bold mb-4">Job Listings</h1>
        <form method="GET" action="{{ url('/jobs') }}" class="mb-6">
            <div class="flex flex-wrap gap-2">
                <input type="text" name="keyword" class="flex-1 px-3 py-2 border border-gray-300 rounded" placeholder="Keyword (e.g., marketing)" value="{{ $keyword ?? '' }}">
                <input type="text" name="location" class="flex-1 px-3 py-2 border border-gray-300 rounded" placeholder="Location (e.g., indonesia)" value="{{ $location ?? '' }}">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>
            </div>
        </form>
        @if (isset($error) && $error)
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ $error }}
            </div>
        @endif
        @if (!empty($jobs) && count($jobs) > 0)
            <div class="grid grid-cols-1 gap-6">
                @foreach ($jobs as $job)
                    <div class="flex bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                        @if (!empty($job['logo']))
                            <div class="flex-shrink-0 flex items-center p-4 bg-gray-50">
                                <img src="{{ $job['logo'] }}" alt="Logo" class="h-16 w-16 object-contain rounded">
                            </div>
                        @endif
                        <div class="flex-1 p-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $job['judul'] ?? '-' }}</h2>
                                @if (!empty($job['link']))
                                    <a href="{{ url('/jobs/detail?url=' . urlencode($job['link'])) }}"
                                       class="ml-4 px-3 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-700 whitespace-nowrap">
                                        Lihat
                                    </a>
                                @endif
                            </div>
                            <div class="mt-1 text-sm text-gray-600">
                                <span class="font-medium">{{ $job['perusahaan'] ?? '-' }}</span>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-2 text-xs text-gray-500">
                                @if (!empty($job['lokasi']))
                                    <span class="inline-flex items-center px-2 py-1 bg-gray-100 rounded">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4.58 8-10A8 8 0 1 0 4 12c0 5.42 8 10 8 10z"/><circle cx="12" cy="12" r="3"/></svg>
                                        {{ $job['lokasi'] }}
                                    </span>
                                @endif
                                @if (!empty($job['gaji']))
                                    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-600 rounded">
                                        <svg class="w-4 h-4 mr-1 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v8m0 0a4 4 0 1 1 0-8m0 8a4 4 0 0 0 0-8"/></svg>
                                        {{ $job['gaji'] }}
                                    </span>
                                @endif
                                @if (!empty($job['dipost']))
                                    <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-600 rounded">
                                        <svg class="w-4 h-4 mr-1 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10m-9 7h10m-2 4a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12z"/></svg>
                                        {{ $job['dipost'] }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            @if ($searchPerformed)
                <p class="text-gray-600">Tidak ada pekerjaan ditemukan. Coba gunakan keyword atau lokasi lain.</p>
            @else
                <p class="text-gray-600">Masukkan keyword dan lokasi, lalu klik Search untuk melihat daftar pekerjaan.</p>
            @endif
        @endif
    </div>
</body>
</html>