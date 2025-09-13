@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Candidate Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}</p>
    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Interview</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($links as $link)
                @php
                    $submissionStatus =
                        $link->interview
                            ->submissions()
                            ->where('candidate_id', auth()->id())
                            ->latest('updated_at')
                            ->first()?->status ?? 'Not started';
                @endphp
                <tr>
                    <td>{{ $link->interview->title }}</td>
                    <td>{{ $link->interview->description }}</td>
                    <td>
                        @if ($submissionStatus === 'draft')
                            Draft
                        @elseif($submissionStatus === 'submitted')
                            Submitted
                        @else
                            Not started
                        @endif
                    </td>
                    <td>
                        <a href="{{ $submissionStatus === 'submitted'
                            ? route('candidate.interview.preview', $link->token)
                            : route('candidate.interview', $link->token) }}"
                            class="btn btn-primary btn-sm">
                            @if ($submissionStatus === 'draft')
                                Edit
                            @elseif($submissionStatus === 'submitted')
                                Preview
                            @else
                                Start Interview
                            @endif
                        </a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No interviews assigned yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
