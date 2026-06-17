@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $institute->name }}</h1>
                <p class="text-muted mb-0">
                    {{ $institute->description ?? 'No description available for this institute.' }}
                </p>
                <p>Courses:</p>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('institutes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Institutes
                </a>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-{{ auth()->user()->role === 'employee' ? '12' : '6' }}">
                <div class="card">
                    <div class="card-body">
                        @if($institute->courses->isEmpty())
                            <p class="mb-0">No courses added yet.</p>
                        @else
                            <div class="list-group">
                                @foreach($institute->courses as $course)
                                    <div class="list-group-item">
                                        <h3 class="h6 mb-0">{{ $course->course_name }}</h3>
                                        <p class="text-muted mb-0 mt-1">
                                            Amount:
                                            <strong>{{ $course->amount !== null ? number_format((float) $course->amount, 2) : 'N/A' }}</strong>
                                            <span class="mx-2">|</span>
                                            Duration:
                                            <strong>{{ $course->duration ?? 'N/A' }}</strong>
                                        </p>
                                        @if($course->description)
                                            <p class="text-muted mb-0 mt-1">{{ $course->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if(auth()->user()->role !== 'employee')
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Course to {{ $institute->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('institutes.courses.store', $institute) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="course_name">Course Name</label>
                                    <input type="text" class="form-control @error('course_name') is-invalid @enderror" id="course_name" name="course_name" value="{{ old('course_name') }}">
                                    @error('course_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" step="0.01" min="0" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}">
                                    @error('amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="duration">Duration</label>
                                    <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" placeholder="e.g. 3 Months">
                                    @error('duration')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button class="btn btn-primary" type="submit">Add Course</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
