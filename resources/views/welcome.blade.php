<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VidHire — One-Way Video Interview Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .hero-section { padding: 80px 0; }
        .nav-link { color: #495057 !important; font-weight: 500; }
        .nav-link:hover { color: #0d6efd !important; }
        .btn-primary { background-color: #0d6efd; border-color: #0d6efd; }
        .btn-primary:hover { background-color: #0b5ed7; border-color: #0a58ca; }
        footer { background-color: #e9ecef; padding: 20px 0; margin-top: 60px; }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">VidHire</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                        @endauth
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Me</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('guides') }}">Usage Docs</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Welcome to VidHire</h1>
            <p class="lead mt-3">A secure, one-way video interview platform built for real-world hiring workflows.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg mt-4">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-4">Get Started</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p class="mb-0 text-muted">
                Built for Horizon Sphere Equity • 2025 | All rights reserved
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>