@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Admission Details</h3>

        <a href="{{ route('admissions.index') }}" class="btn btn-secondary btn-sm">
            ← Back
        </a>
    </div>

    <!-- Admission Card -->
    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Header Info -->
            <h4 class="mb-3">
                {{ $admission->name }}

                <!-- Payment Status Badge -->
                @if($admission->paid_amount >= $admission->total_fees)
                    <span class="badge bg-success">Paid</span>
                @elseif($admission->paid_amount > 0)
                    <span class="badge bg-warning text-dark">Partial</span>
                @else
                    <span class="badge bg-danger">Unpaid</span>
                @endif
            </h4>

            <hr>

            <!-- Basic Info -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $admission->email }}</p>
                    <p><strong>Phone:</strong> {{ $admission->phone }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Created At:</strong> {{ $admission->created_at->format('d M Y') }}</p>
                    <p><strong>Admission ID:</strong> #{{ $admission->id }}</p>
                </div>
            </div>

            <hr>

            <!-- 💰 Payment Breakdown -->
            <h5 class="mb-3">Payment Summary</h5>

            @php
                $total = $admission->total_fees;
                $paid = $admission->paid_amount;
                $remaining = $total - $paid;
            @endphp

            <div class="row text-center">
                <div class="col-md-4">
                    <div class="p-3 border rounded">
                        <h6>Total Fees</h6>
                        <h5 class="text-primary">₹ {{ $total }}</h5>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 border rounded">
                        <h6>Paid Amount</h6>
                        <h5 class="text-success">₹ {{ $paid }}</h5>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 border rounded">
                        <h6>Remaining</h6>
                        <h5 class="text-danger">₹ {{ $remaining }}</h5>
                    </div>
                </div>
            </div>

            <hr>

            <!-- 🧠 RBAC Actions -->
            <div class="d-flex gap-2">

                @can('update', $admission)
                    <a href="{{ route('admissions.edit', $admission->id) }}" class="btn btn-primary btn-sm">
                        Edit
                    </a>
                @endcan

                @can('delete', $admission)
                    <form action="{{ route('admissions.destroy', $admission->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this record?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>
                @endcan

            </div>

        </div>
    </div>

</div>
@endsection