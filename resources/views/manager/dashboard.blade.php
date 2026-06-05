@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manager Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

```
    <div class="row">

        <!-- Manager Profile -->
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">My Profile</h3>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Name:</strong>
                        {{ $manager->name }}
                    </p>

                    <p>
                        <strong>Email:</strong>
                        {{ $manager->email }}
                    </p>

                    <p>
                        <strong>Role:</strong>
                        <span class="badge badge-primary">
                            Manager
                        </span>
                    </p>

                    <a href="{{ route('profile.show', $manager->id) }}"
                       class="btn btn-primary">
                        View My Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Employee Count -->
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ count($employees) }}</h3>
                    <p>Total Employees</p>
                </div>

                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Employee Table -->
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

                    @forelse($employees as $emp)

                    <tr>

                        <td>#{{ $emp->id }}</td>

                        <td>{{ $emp->name }}</td>

                        <td>{{ $emp->email }}</td>

                        <td>
                            <span class="badge badge-success">
                                Employee
                            </span>
                        </td>

                        <td>
                            {{ $emp->created_at->format('M d, Y') }}
                        </td>

                        <td>

                            <a href="{{ route('profile.show', $emp->id) }}"
                               class="btn btn-info btn-sm">
                                View
                            </a>

                            <a href="{{ route('manager.edit', $emp->id) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('manager.delete', $emp->id) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Are you sure?')"
                                        class="btn btn-danger btn-sm">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No employees assigned to you yet.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>
```

</section>

@endsection
