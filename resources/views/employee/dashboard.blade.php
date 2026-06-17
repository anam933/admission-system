@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Employee Dashboard</h1>
        <p class="text-muted mb-0">
            Welcome, {{ $user->name }} | {{ ucfirst($user->role) }}
        </p>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $user->name }}</h3>
                <p>You are logged in as Employee</p>
            </div>
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
        </div>

        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Your Profile</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Full Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge badge-success">Employee</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Member Since</th>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('profile.show', $user->id) }}" class="btn btn-primary">View Full Profile</a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Edit Profile</a>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">My Candidates</h3>
                <a href="{{ route('candidates.create') }}" class="btn btn-sm btn-primary">Add Candidate</a>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Duration</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $candidate)
                            @php($course = $candidate->course)
                            <tr>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->mobile }}</td>
                                <td>{{ optional($course)->course_name ?? 'N/A' }}</td>
                                <td>{{ $course && $course->amount !== null ? number_format((float) $course->amount, 2) : 'N/A' }}</td>
                                <td>{{ optional($course)->duration ?? 'N/A' }}</td>
                                <td>{{ $candidate->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('candidates.edit', $candidate) }}" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No candidates added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
