@extends('layouts.app')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1>Add Admission</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admissions.store') }}" method="POST">
                    @csrf

                    {{-- Candidate --}}
                    <div class="form-group">
                        <label>Select Candidate</label>
                        <select id="candidate_id" name="candidate_id" class="form-control" required>
                            <option value="">-- Select Candidate --</option>

                            @foreach($candidates as $candidate)
                                <option value="{{ $candidate->id }}">
                                    {{ $candidate->name }} ({{ $candidate->mobile }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Course --}}
                    <div class="form-group">
                        <label>Course</label>
                        <input type="text"
                               id="course_name"
                               class="form-control"
                               readonly>
                    </div>

                    {{-- Total Fees --}}
                    <div class="form-group">
                        <label>Total Fees</label>
                        <input type="number"
                               id="total_fees"
                               name="total_fees"
                               class="form-control"
                               readonly
                               required>
                    </div>

                    {{-- Paid Amount --}}
                    <div class="form-group">
                        <label>Paid Amount</label>
                        <input type="number"
                               id="paid_amount"
                               name="paid_amount"
                               class="form-control"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Admission
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function () {

    $('#candidate_id').on('change', function () {

        let id = $(this).val();

        console.log('Candidate Changed:', id);

        if (!id) {
            $('#course_name').val('');
            $('#total_fees').val('');
            return;
        }

        $.ajax({
    url: "{{ url('candidate-details') }}/" + id,
    type: "GET",

    success: function(response) {

        let text = response;

        if (typeof response === "object") {
            $('#course_name').val(response.course_name || '');
            $('#total_fees').val(response.course_fee || 0);
            return;
        }

        let jsonStart = text.indexOf('{');

        if (jsonStart !== -1) {

            let data = JSON.parse(text.substring(jsonStart));

            $('#course_name').val(data.course_name || '');
            $('#total_fees').val(data.course_fee || 0);
        }
    },

    error: function(xhr) {

        let text = xhr.responseText;

        let jsonStart = text.indexOf('{');

        if (jsonStart !== -1) {

            let data = JSON.parse(text.substring(jsonStart));

            $('#course_name').val(data.course_name || '');
            $('#total_fees').val(data.course_fee || 0);

            return;
        }

        alert('Failed to fetch candidate details');
    }
});

    });

});
</script>

@endsection