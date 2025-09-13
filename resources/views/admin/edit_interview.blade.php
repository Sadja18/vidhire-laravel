@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Interview</h1>

    <form method="POST" action="{{ route('interviews.update', $interview->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $interview->title }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $interview->description }}</textarea>
        </div>

        @foreach($interview->questions as $i => $question)
            <div class="mb-3">
                <label>Question {{ $i+1 }}</label>
                <input type="text" name="questions[]" class="form-control" value="{{ $question->text }}" required>
            </div>
        @endforeach

        <button class="btn btn-primary">Update Interview</button>
    </form>

    <form method="POST" action="{{ route('interviews.destroy', $interview->id) }}" class="mt-2">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Delete Interview</button>
    </form>
</div>
@endsection
