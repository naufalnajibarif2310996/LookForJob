<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $judul ?? 'Detail Pekerjaan' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded shadow">
        {{-- Job Title --}}
        <h1 class="text-2xl font-bold mb-3">{{ $judul ?? '-' }}</h1>
        {{-- Company --}}
        <div class="text-gray-600 mb-2">{{ $perusahaan ?? '-' }}</div>

        {{-- Info Badges --}}
        <div class="flex flex-wrap gap-3 mb-4 text-xs">
            @if (!empty($lokasi))
                <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $lokasi }}</span>
            @endif
            @if (!empty($gaji))
                <span class="inline-block bg-green-100 text-green-700 px-2 py-1 rounded">{{ $gaji }}</span>
            @endif
            @if (!empty($dipost))
                <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded">{{ $dipost }}</span>
            @endif
        </div>

        {{-- Job Description / Requirements --}}
        @if(!empty($deskripsi))
            <div class="prose max-w-none mb-6">{!! $deskripsi !!}</div>
        @else
            <div class="mb-6 text-gray-500">Deskripsi pekerjaan tidak tersedia.</div>
        @endif

        {{-- Button Apply or Info --}}
        @if(!empty($lamar_url))
            <a href="{{ $lamar_url }}" 
               target="_blank"
               class="inline-block px-5 py-2 mb-4 bg-green-600 text-white rounded hover:bg-green-700 font-semibold transition">
                Lamar Sekarang
            </a>
        @else
            <div class="mb-4 text-gray-400">Form lamaran tidak tersedia.</div>
        @endif

        {{-- External Link --}}
        <a href="{{ $url }}" class="block text-blue-500 hover:underline mt-2" target="_blank">Lihat di situs asli</a>

        {{-- Back Link --}}
        <div class="mt-6">
            <a href="{{ url('/jobs') }}" class="text-gray-700 hover:text-gray-900">← Kembali ke daftar pekerjaan</a>
        </div>
    </div>
</body>
</html>