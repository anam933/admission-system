@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">Candidates</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('candidates.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Add Candidate
                </a>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Duration</th>
                            <th>Created By</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $candidate)
                            @php($course = $candidate->course)
                            <tr>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->mobile }}</td>
                                <td>{{ $candidate->email ?? 'N/A' }}</td>
                                <td>{{ optional($candidate->institute)->name ?? 'N/A' }}</td>
                                <td>{{ optional($course)->course_name ?? 'N/A' }}</td>
                                <td>{{ $course && $course->amount !== null ? number_format((float) $course->amount, 2) : 'N/A' }}</td>
                                <td>{{ optional($course)->duration ?? 'N/A' }}</td>
                                <td>{{ optional($candidate->createdBy)->name ?? 'N/A' }}</td>
                                <td>{{ $candidate->created_at->format('d M Y') }}</td>
                                <td>
                                    @if($user->role === 'admin' || $candidate->created_by === $user->id)
                                        <a href="{{ route('candidates.edit', $candidate) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @endif

                                    @if($user->role === 'admin')
                                        <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this candidate?')">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No candidates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
