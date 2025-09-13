@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Review Interview: {{ $interview->title }}</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Candidate</th>
                    <th>Review Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $candidate)
                    <tr>
                        <td>{{ $candidate->name }}</td>
                        <td>
                            @if ($candidateStatuses[$candidate->id] === 'submitted')
                                <span class="badge bg-success">Submitted</span>
                            @elseif($candidateStatuses[$candidate->id] === 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @else
                                <span></span>
                            @endif
                        </td>
                        <td>
                            @if ($candidateStatuses[$candidate->id] === 'submitted')

                                <a href="{{ route('reviewer.interview.candidate.preview', [$interview->id, $candidate->id]) }}"
                                    class="btn btn-primary btn-sm">Preview</a>
                            @elseif($candidateStatuses[$candidate->id] === 'draft')
                                <a href="{{ route('reviewer.interview.candidate.review', [$interview->id, $candidate->id]) }}"
                                    class="btn btn-primary btn-sm">Continue Review</a>
                            @else
                                <a href="{{ route('reviewer.interview.candidate.review', [$interview->id, $candidate->id]) }}"
                                    class="btn btn-primary btn-sm">Review</a>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('reviewer.dashboard') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
