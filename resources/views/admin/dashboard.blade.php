@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('interviews.create') }}" class="btn btn-success mb-3">Create Interview</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interviews as $interview)
            <tr>
                <td>{{ $interview->title }}</td>
                <td>{{ $interview->description }}</td>
                <td>{{ $interview->created_at->format('Y-m-d') }}</td>
                <td>
                    <a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-primary btn-sm">Edit</a>

                    <form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>

                    <a href="{{ route('interviews.generate_link', $interview->id) }}" class="btn btn-warning btn-sm">Generate Link</a>

                    <a href="{{ route('candidate_links.dashboard') }}" class="btn btn-info mb-3">View Candidate Links</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No interviews found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
</div>
@endsection
