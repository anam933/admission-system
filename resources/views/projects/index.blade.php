@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h3>Projects</h3>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Create Project</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->title }}</td>
                            <td>{{ ucfirst($project->status) }}</td>
                            <td>{{ $project->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('admin.projects.delete', $project->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete project?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
