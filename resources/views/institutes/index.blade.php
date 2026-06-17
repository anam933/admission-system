@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Institutes</h1>
                <p class="text-muted mb-0">Select an institute, then view its details below.</p>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Select Your Institute</h3>
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('tenant.switch') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="institute_id">Institute</label>
                                    <select name="institute_id" id="institute_id" class="form-control">
                                        <option value="">All Institutes</option>
                                        @foreach($institutes as $institute)
                                            <option value="{{ $institute->id }}" @selected(optional($selectedInstitute)->id === $institute->id)>
                                                {{ $institute->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Show Details
                                </button>
                            </form>
                        @else
                            <div class="form-group mb-0">
                                <label>Institute</label>
                                <input type="text" class="form-control" value="{{ optional($selectedInstitute)->name ?? 'Not assigned' }}" readonly>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $selectedInstitute ? $selectedInstitute->name . ' Details' : 'Institute Details' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($selectedInstitute)
                            <p class="mb-2">
                                <strong>Name:</strong> {{ $selectedInstitute->name }}
                            </p>
                            <p class="mb-2">
                                <strong>Courses:</strong> {{ $selectedInstitute->courses_count ?? 0 }}
                            </p>
                            <p class="mb-3">
                                <strong>Description:</strong><br>
                                {{ $selectedInstitute->description ?? 'No description available for this institute yet.' }}
                            </p>

                            <a href="{{ route('institutes.show', $selectedInstitute) }}" class="btn btn-outline-primary">
                                Open Full Institute Page
                            </a>
                        @else
                            <p class="mb-0 text-muted">
                                Choose an institute from the form on the left to see its description and summary here.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
