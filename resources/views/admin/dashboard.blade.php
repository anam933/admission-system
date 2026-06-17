@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Admin Dashboard</h1>
                <p class="text-muted mb-0">
                    Welcome, {{ $user->name }} | {{ ucfirst($user->role) }}
                </p>
                <p class="text-muted mb-0">
                    Institute:
                    <strong>{{ $institute->name ?? 'All Institutes' }}</strong>
                </p>
                <p class="text-muted mb-0">
                    Courses loaded:
                    <strong>{{ $courses->count() }}</strong>
                </p>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $users->count() }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $users->where('role', 'manager')->count() }}</h3>
                        <p>Managers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $users->where('role', 'employee')->count() }}</h3>
                        <p>Employees</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $candidates->count() }}</h3>
                        <p>Candidates</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created By</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $listedUser)
                            <tr>
                                <td>{{ $listedUser->id }}</td>
                                <td>{{ $listedUser->name }}</td>
                                <td>{{ $listedUser->email }}</td>
                                <td>
                                    <span class="badge badge-primary text-uppercase">
                                        {{ $listedUser->role }}
                                    </span>
                                </td>
                                <td>{{ $listedUser->created_by ?? 'Self' }}</td>
                                <td>{{ $listedUser->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Recent Candidates</h3>
                <a href="{{ route('candidates.index') }}" class="btn btn-sm btn-primary">Open Candidates</a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Institute</th>
                            <th>Course</th>
                            <th>Amount</th>
                            <th>Duration</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates->take(5) as $candidate)
                            @php($course = $candidate->course)
                            <tr>
                                <td>{{ $candidate->name }}</td>
                                <td>{{ $candidate->mobile }}</td>
                                <td>{{ optional($candidate->institute)->name ?? 'N/A' }}</td>
                                <td>{{ optional($course)->course_name ?? 'N/A' }}</td>
                                <td>{{ $course && $course->amount !== null ? number_format((float) $course->amount, 2) : 'N/A' }}</td>
                                <td>{{ optional($course)->duration ?? 'N/A' }}</td>
                                <td>{{ optional($candidate->createdBy)->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No candidates found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
