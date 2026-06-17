@extends('layouts.app')

@section('content')

@php
    $user = auth()->user();
    $institute = $user->institute;
@endphp

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Dashboard</h1>

                    <p>
                        Welcome, <b>{{ $user->name }}</b>
                        <br>
                        Role: <b>{{ ucfirst($user->role) }}</b>
                    </p>

                    <p>
                        Institute:
                        <span class="badge badge-info">
                            {{ $institute->name ?? ($user->role === 'admin' ? 'All Institutes' : 'Not Assigned') }}
                        </span>
                    </p>

                </div>

            </div>

        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <!-- ROLE CARDS -->
            <div class="row">

                @if($user->role == 'admin')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>Admin</h3>
                            <p>Full System Access</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </div>
                @endif


                @if($user->role == 'manager')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>Manager</h3>
                            <p>Manage Employees</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                @endif


                @if($user->role == 'employee')
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Employee</h3>
                            <p>My Tasks</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- OPTIONAL: DATA SECTION -->
            <div class="row mt-4">

                @if(isset($courses))
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Courses</h3>
                        </div>

                        <div class="card-body">

                            <ul>
                                @foreach($courses as $course)
                                    <li>{{ $course->course_name }}</li>
                                @endforeach
                            </ul>

                        </div>
                    </div>

                </div>
                @endif


                @if($user->role == 'admin' && isset($users))
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users</h3>
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Institute</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $u)
                                        <tr>
                                            <td>{{ $u->name }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->role }}</td>
                                            <td>{{ $u->institute->name ?? 'All' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
                @endif

            </div>

        </div>
    </section>

</div>

@endsection