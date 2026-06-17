@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Employee</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('manager.update', $employee->id) }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $employee->name }}" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $employee->email }}" class="form-control">
                    </div>

                    <button class="btn btn-primary">Update</button>

                </form>
            </div>
        </div>
    </div>
</section>

@endsection