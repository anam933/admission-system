@extends('layouts.app')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Admission Management</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admissions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Admission
                </a>
            </div>
        </div>
    </div>
</div>
<section class="content">
<div class="container-fluid">
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card">
<div class="card-body">
<table class="table table-bordered table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Candidate</th>
    <th>Course</th>
    <th>Total Fees</th>
    <th>Paid</th>
    <th>Remaining</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@forelse($admissions as $admission)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $admission->candidate->name ?? '-' }}</td>
    <td>{{ $admission->course->course_name ?? '-' }}</td>
    <td>â‚¹ {{ $admission->total_fees }}</td>
    <td>â‚¹ {{ $admission->paid_amount }}</td>
    <td>â‚¹ {{ $admission->remaining_amount }}</td>
    <td>
        @if($admission->status == 'converted')
            <span class="badge badge-success">Confirmed</span>
        @elseif($admission->status == 'rejected')
            <span class="badge badge-danger">Rejected</span>
        @else
            <span class="badge badge-warning">New</span>
        @endif
    </td>
    <td>
        <a href="{{ route('admissions.edit', $admission->id) }}" class="btn btn-info btn-sm">Edit</a>
        <form action="{{ route('admissions.destroy', $admission->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">No Records Found</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</section>
@endsection