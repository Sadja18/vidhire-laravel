@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Interview</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.interviews.store') }}">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Question 1</label>
            <input type="text" name="questions[]" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Question 2</label>
            <input type="text" name="questions[]" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Question 3</label>
            <input type="text" name="questions[]" class="form-control" required>
        </div>
        <button class="btn btn-primary">Create Interview</button>
    </form>
</div>
@endsection
