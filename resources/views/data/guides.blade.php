@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Usage Documentation</h1>
    <p class="lead text-center">Access role-specific guides below:</p>

    <div class="row mt-4">
        <div class="col-md-4 text-center">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Admin Guide</h5>
                    <p class="card-text">Create interviews, add questions.</p>
                    <a href="{{ asset('guide-files/admin-guide.pdf') }}" target="_blank" class="btn btn-success">View PDF</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Reviewer Guide</h5>
                    <p class="card-text">View submissions, score answers, leave comments.</p>
                    {{-- <a href="{{ asset('guide-files/reviewer-guide.pdf') }}" target="_blank" class="btn btn-success">View PDF</a> --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">Candidate Guide</h5>
                    <p class="card-text">Record your answer, submit video, wait for feedback.</p>
                    <a href="{{ asset('guide-files/candidate-guide.pdf') }}" target="_blank" class="btn btn-success">View PDF</a>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <p class="text-center text-muted">
        These guides were created using Scribe Chrome extension from my own demo walkthrough.
        All files are stored in <code>/public/guides-files/</code> and served directly.
    </p>
</div>
@endsection