@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card card-primary">

                <div class="card-header">
                    <h3 class="card-title">Register User</h3>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="card-body">

                        <!-- NAME -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name') }}" required>
                        </div>

                        <!-- EMAIL -->
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email') }}" required>
                        </div>

                        <!-- PASSWORD -->
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <!-- ROLE -->
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="employee">Employee</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            Register
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection