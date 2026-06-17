@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manager Dashboard</h1>
                <p class="text-muted mb-0">
                    Welcome, {{ $user->name }} | {{ ucfirst($user->role) }}
                </p>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">My Profile</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Role:</strong> <span class="badge badge-primary">Manager</span></p>
                        <a href="{{ route('profile.show', $user->id) }}" class="btn btn-primary">View My Profile</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $employees->count() }}</h3>
                        <p>Total Employees</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>

                <div class="small-box bg-success mt-3">
                    <div class="inner">
                        <h3>{{ $candidates->count() }}</h3>
                        <p>My Candidates</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Your Employees</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>#{{ $employee->id }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>
                                    <span class="badge badge-success">Employee</span>
                                </td>
                                <td>{{ $employee->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('profile.show', $employee->id) }}" class="btn btn-info btn-sm">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No employees assigned to you yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
