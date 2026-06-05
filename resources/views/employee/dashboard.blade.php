@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Employee Dashboard</h1>
        <p class="text-muted">
            Welcome {{ $employee->name }}, here's your profile information
        </p>
    </div>
</div>

<section class="content">
    <div class="container-fluid">


    <!-- Welcome Box -->
    <div class="small-box bg-success">
        <div class="inner">
            <h3>{{ $employee->name }}</h3>
            <p>You are logged in as Employee</p>
        </div>

        <div class="icon">
            <i class="fas fa-user"></i>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="card card-success">

        <div class="card-header">
            <h3 class="card-title">Your Profile</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="30%">Full Name</th>
                    <td>{{ $employee->name }}</td>
                </tr>

                <tr>
                    <th>Email Address</th>
                    <td>{{ $employee->email }}</td>
                </tr>

                <tr>
                    <th>Role</th>
                    <td>
                        <span class="badge badge-success">
                            Employee
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Member Since</th>
                    <td>
                        {{ $employee->created_at->format('M d, Y') }}
                    </td>
                </tr>

            </table>

            <div class="mt-3">

                <a href="{{ route('profile.show', $employee->id) }}"
                   class="btn btn-primary">
                    View Full Profile
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="btn btn-secondary">
                    Edit Profile
                </a>

            </div>

        </div>

    </div>

    <!-- System Information -->
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">System Information</h3>
        </div>

        <div class="card-body">

            <p>
                <strong>Role Permissions:</strong>
                As an employee, you can only view your own profile and dashboard information.
            </p>

            <p>
                <strong>Manager Access:</strong>
                Your manager can view your profile and information.
            </p>

            <p>
                <strong>Need Help?</strong>
                Contact your manager or the admin for assistance.
            </p>

        </div>

    </div>

</div>


</section>

@endsection
