@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Login</h2>
    <form method="POST" action="/login">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Login</button>
    </form>
    @if($errors->any())
        <div class="mt-3 text-danger">{{ $errors->first() }}</div>
    @endif
</div>
@endsection