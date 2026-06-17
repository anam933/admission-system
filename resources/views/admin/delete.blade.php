@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit User</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.update', $user->id) }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control">
                            <option value="employee" {{ $user->role=='employee'?'selected':'' }}>Employee</option>
                            <option value="manager" {{ $user->role=='manager'?'selected':'' }}>Manager</option>
                            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Update</button>

                </form>
            </div>
        </div>
    </div>
</section>

@endsection