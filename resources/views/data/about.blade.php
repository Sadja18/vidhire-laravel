@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">About Me</h1>
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <p class="lead">
                Hi! I'm a full-stack developer passionate about building clean, functional applications under pressure.
            </p>
            <p>
                This project, <strong>VidHire</strong>, was built in 24 hours as part of Horizon Sphere Equity's developer challenge.
            </p>
            <div class="mt-4">
                <a href="https://github.com/Sadja18/vidhire-laravel" target="_blank" class="btn btn-outline-secondary me-2">
                    🖥️ GitHub Repo
                </a>
                <a href="https://chat.qwen.ai/s/deploy/d41b3a15-9453-4e8c-b185-dc6ad962be9c" target="_blank" class="btn btn-outline-primary me-2">
                    🌐 Portfolio
                </a>
                <a href="https://www.linkedin.com/in/naman-m-8575a6144/" target="_blank" class="btn btn-outline-info">
                    💼 LinkedIn
                </a>
            </div>
            <hr>
            <small class="text-muted">
                This app runs on Laravel (PHP 8.2) + MySQL DB + Apache2. Full source code and deployment details are available in the repo.
            </small>
        </div>
    </div>
</div>
@endsection