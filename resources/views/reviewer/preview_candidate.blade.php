@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Review Preview: {{ $candidate->name }} — {{ $interview->title }}</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Question</th>
                <th>Video URL</th>
                <th>Score</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $submission)
                <tr>
                    <td>{{ $submission->question->text }}</td>
                    <td><a href="{{ $submission->video_url }}" target="_blank">View</a></td>
                    <td><input type="number" class="form-control" value="{{ $reviews[$submission->id]->score }}" readonly></td>
                    <td><input type="text" class="form-control" value="{{ $reviews[$submission->id]->comment }}" readonly></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('reviewer.interview.candidates', $interview->id) }}" class="btn btn-secondary">Back</a>
</div>
@endsection
