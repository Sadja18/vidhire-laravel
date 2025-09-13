@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Reviewer Dashboard</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Interview</th>
                <th>Number of Submissions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interviews as $interview)
                <tr>
                    <td>{{ $interview->title }}</td>
                    <td>
                        <span class="badge bg-success">
                            {{ $interview->submissions()->where('status', 'submitted')->distinct('candidate_id')->count('candidate_id') }}
                            submission{{ $interview->submissions()->where('status', 'submitted')->distinct('candidate_id')->count('candidate_id') > 1 ? 's' : '' }}
                        </span>
                    </td>

                    <td>
                        @php
                            $numCandidates = $interview
                                ->submissions()
                                ->where('status', 'submitted')
                                ->distinct('candidate_id')
                                ->count('candidate_id');
                        @endphp
                        @if ($numCandidates === 0)
                            <button class="btn btn-secondary btn-sm" disabled>No Submissions</button>
                        @else
                            <a href="{{ route('reviewer.interview.candidates', $interview->id) }}"
                                class="btn btn-primary btn-sm">Review</a>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="3">No interviews available for review.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
@endsection
