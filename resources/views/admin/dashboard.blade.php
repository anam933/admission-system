@extends('layouts.app')

@section('content')

<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <h1 class="mb-2">Admin Dashboard</h1>
        <p class="text-muted">Manage users and system overview</p>
    </div>
</section>

<!-- Main Content -->
<section class="content">

    <!-- Welcome Card -->
    <div class="card">
        <div class="card-body">
            <h4>Welcome, {{ auth()->user()->name }}</h4>

            <p class="mb-1">
                <strong>Email:</strong> {{ auth()->user()->email }}
            </p>

            <p class="mb-0">
                <strong>Role:</strong>
                <span class="badge badge-danger text-uppercase">
                    {{ auth()->user()->role }}
                </span>
            </p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mt-3">

        <div class="col-lg-4 col-12">
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

        <div class="col-lg-4 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $users->where('role','manager')->count() }}</h3>
                    <p>Managers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $users->where('role','employee')->count() }}</h3>
                    <p>Employees</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Users Table -->
    

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

                @foreach($users as $user)

                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            <span class="badge badge-primary text-uppercase">
                                {{ $user->role }}
                            </span>
                        </td>

                        <td>
                            {{ $user->created_by ?? 'Self' }}
                        </td>

                        <td>
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>
    </div>

</section>

@endsection