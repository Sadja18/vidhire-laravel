@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Candidate Links</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Interview</th>
                <th>Candidate</th>
                <th>Token</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($links as $link)
            <tr>
                <td>{{ $link->interview->title }}</td>
                <td>{{ $link->candidate->name }} ({{ $link->candidate->email }})</td>
                <td>{{ $link->token }}</td>
                <td>
                    <form action="{{ route('candidate_links.destroy', $link->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No candidate links generated yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
