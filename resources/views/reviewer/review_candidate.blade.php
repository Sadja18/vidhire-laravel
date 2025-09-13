@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Review {{ $candidate->name }} for {{ $interview->title }}</h1>

        <form method="POST"
            action="{{ route('reviewer.interview.candidate.review.save', [$interview->id, $candidate->id]) }}">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Video URL</th>
                        <th>Score (1-5)</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions as $submission)
                        <tr>
                            <td>{{ $submission->question->text }}</td>
                            <td><a href="{{ $submission->video_url }}" target="_blank">View</a></td>
                            <td>
                                <input type="number" name="score[{{ $submission->id }}]" class="form-control" min="1"
                                    max="5" value="{{ $reviews[$submission->id]->score ?? '' }}" required>
                            </td>
                            <td>
                                <input type="text" name="comment[{{ $submission->id }}]" class="form-control"
                                    value="{{ $reviews[$submission->id]->comment ?? '' }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" name="status" value="draft" class="btn btn-secondary">Save Draft</button>
            <button type="submit" name="status" value="submit" class="btn btn-primary">Submit Final</button>
            <a href="{{ route('reviewer.interview.candidates', $interview->id) }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
