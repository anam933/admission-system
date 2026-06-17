@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Admission Form</h2>
    <form method="POST" action="{{ route('admissions.store') }}">
        @csrf
        <!-- Name -->
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <!-- Email -->
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <!-- Phone -->
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <!-- Total Fees -->
        <div class="mb-3">
            <label>Total Fees</label>
            <input type="number" id="total_fees" name="total_fees" class="form-control" required>
        </div>
        <!-- Paid Fees -->
        <div class="mb-3">
            <label>Paid Amount</label>
            <input type="number" id="paid_amount" name="paid_amount" class="form-control" required>
        </div>
        <!-- Remaining -->
        <div class="mb-3">
            <label>Remaining Amount</label>
            <input type="number" id="remaining_amount" name="remaining_amount" class="form-control" readonly>
        </div>
        <button type="submit" class="btn btn-primary">
            Submit Admission
        </button>
    </form>
</div>
<!-- JS for calculation -->
<script>
    const totalFees = document.getElementById('total_fees');
    const paidAmount = document.getElementById('paid_amount');
    const remainingAmount = document.getElementById('remaining_amount');
    function calculateRemaining() {
        let total = parseFloat(totalFees.value) || 0;
        let paid = parseFloat(paidAmount.value) || 0;
        let remaining = total - paid;
        remainingAmount.value = remaining >= 0 ? remaining : 0;
    }
    totalFees.addEventListener('input', calculateRemaining);
    paidAmount.addEventListener('input', calculateRemaining);
</script>
@endsection