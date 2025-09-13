@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $link->interview->title }} — Preview</h1>
        <p>{{ $link->interview->description }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Video URL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($link->interview->questions as $question)
                    <tr>
                        <td>{{ $question->text }}</td>
                        <td>
                            <input type="text" class="form-control"
                                value="{{ $submissions[$question->id]->video_url ?? '' }}" readonly>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('candidate.dashboard') }}" class="btn btn-secondary">Go Back</a>
    </div>
@endsection
