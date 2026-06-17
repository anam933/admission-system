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

                {{-- NAME --}}
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                {{-- PASSWORD --}}
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                {{-- ROLE --}}
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" required>

                        @if(auth()->user()->role === 'admin')
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                        @endif

                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>

                    </select>
                </div>

                {{-- INSTITUTE (ONLY FOR ADMIN) --}}
                @if(auth()->user()->role === 'admin')
                <div class="mb-3">
                    <label>Institute</label>
                    <select name="institute_id" class="form-control">

                        <option value="">Select institute</option>

                        @foreach($institutes as $institute)
                            <option value="{{ $institute->id }}"
                                {{ old('institute_id') == $institute->id ? 'selected' : '' }}>
                                {{ $institute->name }}
                            </option>
                        @endforeach

                    </select>
                </div>
                @endif

                {{-- SUBMIT --}}
                <button type="submit" class="btn btn-primary">
                    Create User
                </button>

            </form>

        </div>
    </div>
</section>

@endsection