@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Generate Candidate Link for "{{ $interview->title }}"</h1>

    <form method="POST" action="{{ route('admin.interviews.store_candidate_link', $interview->id) }}">
        @csrf
        <div class="mb-3">
            <label>Select Candidate</label>
            <select name="candidate_id" class="form-control" required>
                @foreach($candidates as $candidate)
                    <option value="{{ $candidate->id }}">{{ $candidate->name }} ({{ $candidate->email }})</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary">Generate Link</button>
    </form>
</div>
@endsection
