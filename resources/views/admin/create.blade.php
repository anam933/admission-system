@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <h1>Create User</h1>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="employee">Employee</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Create User
                </button>

            </form>

        </div>
    </div>
</section>

@endsection