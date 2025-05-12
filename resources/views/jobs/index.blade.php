<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Job Listings</h1>

        <!-- Form untuk mencari pekerjaan -->
        <form method="GET" action="{{ url('/jobs/frontend') }}" class="mb-4">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" name="keyword" class="form-control" placeholder="Keyword (e.g., developer)" value="{{ $keyword ?? '' }}">
                </div>
                <div class="col-md-5">
                    <input type="text" name="location" class="form-control" placeholder="Location (e.g., indonesia)" value="{{ $location ?? '' }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>

        <!-- Tampilkan error jika ada -->
        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        <!-- Tampilkan daftar pekerjaan -->
        @if (!empty($jobs) && count($jobs) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Date Posted</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $index => $job)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $job['title'] }}</td>
                            <td>{{ $job['company'] }}</td>
                            <td>{{ $job['location'] }}</td>
                            <td>{{ $job['date_posted'] }}</td>
                            <td>
                                <a href="{{ $job['url'] }}" target="_blank" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No jobs found. Try searching with different keywords or location.</p>
        @endif
    </div>
</body>
</html>