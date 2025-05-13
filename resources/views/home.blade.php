<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Look For Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
        }

        .main-content {
            flex: 1;
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
        }

        .hero-section {
            padding: 60px 0 40px 0;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: #2d3a4b;
        }

        .hero-lead {
            font-size: 1.3rem;
            color: #4b5563;
            margin-bottom: 30px;
        }

        .btn-main {
            font-size: 1.1rem;
            padding: 12px 32px;
            margin: 0 10px 10px 0;
        }

        footer {
            background: #1e293b;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">Look For Job</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/jobs">Cari Lowongan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cv">Generate CV</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten utama dibungkus dengan .main-content -->
    <div class="main-content">
        <section class="hero-section">
            <div class="container">
                <div class="text-center">
                    <h1 class="hero-title mb-3">Selamat Datang di <span style="color:#6366f1">Look For Job</span></h1>
                    <p class="hero-lead">Temukan lowongan kerja impianmu dengan mudah dan buat CV profesional hanya dalam beberapa klik!</p>
                    <a href="/jobs" class="btn btn-main btn-primary">Cari Lowongan</a>
                    <a href="/cv" class="btn btn-main btn-outline-primary">Generate CV</a>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer akan selalu berada di bawah -->
    <footer class="text-white text-center py-3">
        <p>&copy; 2025 Look For Job. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
