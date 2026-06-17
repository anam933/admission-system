@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1>Edit Admission</h1>
    </div>
</div>

<section class="content">
<div class="container-fluid">

<div class="card">
<div class="card-body">

<form action="{{ route('admissions.update', $admission->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Name</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ $admission->name }}"
               required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ $admission->email }}"
               required>
    </div>

    <div class="form-group">
        <label>Phone</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="{{ $admission->phone }}"
               required>
    </div>

    <div class="form-group">
        <label>Total Fees</label>
        <input type="number"
               id="total_fees"
               name="total_fees"
               class="form-control"
               value="{{ $admission->total_fees }}"
               required>
    </div>

    <div class="form-group">
        <label>Paid Amount</label>
        <input type="number"
               id="paid_amount"
               name="paid_amount"
               class="form-control"
               value="{{ $admission->paid_amount }}"
               required>
    </div>

    <div class="form-group">
        <label>Remaining Amount</label>
        <input type="number"
               id="remaining_amount"
               class="form-control"
               value="{{ $admission->remaining_amount }}"
               readonly>
    </div>

    <div class="form-group">
        <label>Status</label>

        <select name="status" class="form-control">
            <option value="new"
                {{ $admission->status == 'new' ? 'selected' : '' }}>
                New
            </option>

            <option value="converted"
                {{ $admission->status == 'converted' ? 'selected' : '' }}>
                Converted
            </option>

            <option value="rejected"
                {{ $admission->status == 'rejected' ? 'selected' : '' }}>
                Rejected
            </option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">
        Update Admission
    </button>

    <a href="{{ route('admissions.index') }}"
       class="btn btn-secondary">
       Back
    </a>

</form>

</div>
</div>

</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const total = document.getElementById('total_fees');
    const paid = document.getElementById('paid_amount');
    const remaining = document.getElementById('remaining_amount');

    function calculate() {
        let t = parseFloat(total.value) || 0;
        let p = parseFloat(paid.value) || 0;

        remaining.value = t - p;
    }

    total.addEventListener('input', calculate);
    paid.addEventListener('input', calculate);
});
</script>

@endsection