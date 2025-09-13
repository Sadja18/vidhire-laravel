@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.interviews.create') }}" class="btn btn-success mb-3">Create Interview</a>

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
                            <a href="{{ route('admin.interviews.edit', $interview->id) }}"
                                class="btn btn-primary btn-sm">Edit</a>

                            <form action="{{ route('admin.interviews.destroy', $interview->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>

                            {{-- <a href="{{ route('admin.interviews.generate_link', $interview->id) }}"
                                class="btn btn-warning btn-sm">Generate Link</a> --}}
                            @if ($interview->candidate_links_count < $totalCandidates)
                                <a href="{{ route('admin.interviews.generate_link', $interview->id) }}"
                                    class="btn btn-warning btn-sm">Generate Link</a>
                            @endif

                            {{-- <a href="{{ route('admin.candidate_links.dashboard') }}" class="btn btn-info mb-3">View Candidate Links</a> --}}
                            @if ($interview->candidate_links_count > 0)
                                <a href="{{ route('admin.candidate_links.dashboard', $interview->id) }}"
                                    class="btn btn-info btn-sm">View Candidate Links</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No interviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
