@php
    $isEdit = isset($candidate) && $candidate;
    $selectedInstituteId = old('institute_id', $selectedInstituteId ?? ($candidate->institute_id ?? null));
    $selectedCourseId = old('course_id', $candidate->course_id ?? null);
    $submitLabel = $submitLabel ?? ($isEdit ? 'Update Candidate' : 'Save Candidate');
@endphp

<div class="card">
    <div class="card-body">
        <form action="{{ $isEdit ? route('candidates.update', $candidate) : route('candidates.store') }}" method="POST">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="name">Candidate Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $candidate->name ?? '') }}">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $candidate->mobile ?? '') }}">
                @error('mobile')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email <small class="text-muted">(optional)</small></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $candidate->email ?? '') }}">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="institute_id">Institute</label>

                @if($user->role === 'admin')
                    <select class="form-control @error('institute_id') is-invalid @enderror" id="institute_id" name="institute_id">
                        <option value="">Select Institute</option>
                        @foreach($institutes as $institute)
                            <option value="{{ $institute->id }}" @selected((string) $selectedInstituteId === (string) $institute->id)>
                                {{ $institute->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <input type="hidden" id="institute_id" name="institute_id" value="{{ $selectedInstituteId }}">
                    <input type="text" class="form-control" value="{{ optional($user->institute)->name ?? 'Not Assigned' }}" readonly>
                @endif

                @error('institute_id')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="course_id">Course</label>
                <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id">
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option
                            value="{{ $course->id }}"
                            data-institute-id="{{ $course->institute_id }}"
                            data-amount="{{ $course->amount !== null ? number_format((float) $course->amount, 2, '.', '') : '' }}"
                            data-duration="{{ $course->duration ?? '' }}"
                            @selected((string) $selectedCourseId === (string) $course->id)
                        >
                            {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="course_amount">Course Amount</label>
                    <input type="text" class="form-control" id="course_amount" value="" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="course_duration">Course Duration</label>
                    <input type="text" class="form-control" id="course_duration" value="" readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
            <a href="{{ route('candidates.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const instituteField = document.getElementById('institute_id');
    const courseSelect = document.getElementById('course_id');
    const amountField = document.getElementById('course_amount');
    const durationField = document.getElementById('course_duration');

    if (!instituteField || !courseSelect || !amountField || !durationField) {
        return;
    }

    const courseOptions = Array.from(courseSelect.querySelectorAll('option[data-institute-id]'));

    function updateCourseDetails() {
        const selectedOption = courseSelect.selectedOptions[0];

        amountField.value = selectedOption ? (selectedOption.dataset.amount || '') : '';
        durationField.value = selectedOption ? (selectedOption.dataset.duration || '') : '';
    }

    function syncCourses() {
        const instituteId = instituteField.value;
        const shouldFilterByInstitute = instituteField.tagName === 'SELECT';
        let firstVisibleOption = null;

        courseOptions.forEach((option) => {
            const visible = shouldFilterByInstitute
                ? (instituteId && option.dataset.instituteId === instituteId)
                : true;
            option.hidden = !visible;
            option.disabled = !visible;

            if (visible && !firstVisibleOption) {
                firstVisibleOption = option;
            }
        });

        const selectedOption = courseSelect.selectedOptions[0];
        if (!selectedOption || selectedOption.hidden) {
            courseSelect.value = firstVisibleOption ? firstVisibleOption.value : '';
        }

        updateCourseDetails();
    }

    courseSelect.addEventListener('change', updateCourseDetails);

    if (instituteField.tagName === 'SELECT') {
        instituteField.addEventListener('change', syncCourses);
    }

    syncCourses();
});
</script>
