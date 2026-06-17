@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>{{ $project->exists ? 'Edit Project' : 'Create Project' }}</h4>

            <form method="POST" action="{{ $project->exists ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}">
                @csrf
                @if($project->exists)
                    <input type="hidden" name="_method" value="POST">
                @endif

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ old('description', $project->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        @foreach(['planning','active','completed'] as $s)
                            <option value="{{ $s }}" {{ old('status', $project->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

@endsection
