<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdmissionController extends Controller
{
    /**
     * Get active institute
     */
    private function getActiveInstituteId()
    {
        $user = Auth::user();

        return $user->role === 'admin'
            ? session('selected_institute_id')
            : $user->institute_id;
    }

    /**
     * LIST
     */
    public function index()
    {
        $user = Auth::user();
        $instituteId = $this->getActiveInstituteId();

        $admissions = Admission::where('institute_id', $instituteId)
            ->when($user->role === 'employee', function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })
            ->latest()
            ->get();

        return view('admissions.index', compact('admissions'));
    }

    /**
     * CREATE
     */
    public function create()
    {
        $instituteId = $this->getActiveInstituteId();

        $candidates = Candidate::with('course')
            ->where('institute_id', $instituteId)
            ->latest()
            ->get();

        return view('admissions.create', compact('candidates'));
    }

    /**
     * STORE (FIXED MAIN BUG HERE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'total_fees'   => 'required|numeric',
            'paid_amount'   => 'required|numeric',
        ]);

        $instituteId = $this->getActiveInstituteId();

        $candidate = Candidate::with('course')
            ->where('id', $request->candidate_id)
            ->where('institute_id', $instituteId)
            ->firstOrFail();

        Admission::create([
            'candidate_id'      => $candidate->id,
            'course_id'         => $candidate->course_id,

            'name'              => $candidate->name,
            'email'             => $candidate->email,
            'phone'             => $candidate->mobile,

            'total_fees'        => $request->total_fees,
            'paid_amount'       => $request->paid_amount,
            'remaining_amount'  => $request->total_fees - $request->paid_amount,

            // ⚠️ IMPORTANT FIX (status consistent)
            'status'            => 'new',

            'institute_id'      => $instituteId,
            'created_by'        => Auth::id(),
        ]);

        return redirect()
            ->route('admissions.index')
            ->with('success', 'Admission created successfully.');
    }

    /**
     * SHOW
     */
    public function show($id)
    {
        $instituteId = $this->getActiveInstituteId();

        $admission = Admission::where('institute_id', $instituteId)
            ->findOrFail($id);

        return view('admissions.show', compact('admission'));
    }

    /**
     * EDIT
     */
    public function edit($id)
    {
        $instituteId = $this->getActiveInstituteId();

        $admission = Admission::where('institute_id', $instituteId)
            ->findOrFail($id);

        return view('admissions.edit', compact('admission'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
{
    $instituteId = $this->getActiveInstituteId();

    $admission = Admission::where('institute_id', $instituteId)
        ->findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'total_fees' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'status' => 'required'
    ]);

    $validated['remaining_amount'] =
        $validated['total_fees'] - $validated['paid_amount'];

    $admission->update($validated);

    return redirect()
        ->route('admissions.index')
        ->with('success', 'Admission updated successfully.');
}

    /**
     * DELETE
     */
       public function destroy($id)
    {
        $instituteId = $this->getActiveInstituteId();

        $admission = Admission::where('institute_id', $instituteId)
            ->findOrFail($id);

        $admission->delete();

        return redirect()->route('admissions.index')
            ->with('success', 'Admission deleted successfully.');
    }

    /**
     * AJAX (candidate details)
     */
    public function getCandidate($id)
    {
        $candidate = Candidate::with('course')->findOrFail($id);

        return response()->json([
            'course_name' => $candidate->course->course_name ?? '',
            'course_fee'  => $candidate->course->amount ?? 0
        ]);
    }
}