@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $link->interview->title }}</h1>
        <p>{{ $link->interview->description }}</p>

        <form method="POST" action="{{ route('candidate.interview.submit', $link->token) }}">
            @csrf
            @foreach ($link->interview->questions as $question)
                <div class="mb-3">
                    <label>{{ $question->text }}</label>
                    <input type="text" name="question_{{ $question->id }}" class="form-control" placeholder="Paste video URL"
                        value="{{ $submissions[$question->id]->video_url ?? '' }}">
                </div>
            @endforeach

            <button type="submit" name="status" value="draft" class="btn btn-secondary">Save Draft</button>
            <button type="submit" name="status" value="submit" class="btn btn-primary">Submit Final</button>
        </form>

    </div>
@endsection
