<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Course;
use App\Models\Institute;
use App\Models\User;
use App\Scopes\TenantScope;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CandidateController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $query = Candidate::query()->with([
            'institute',
            'createdBy',
        ]);

        if ($user->role === 'admin') {
            $query->with([
                'course' => fn ($courseQuery) => $courseQuery->withoutGlobalScope(TenantScope::class),
            ]);
        } else {
            $query->with('course')
                ->where('created_by', $user->id);
        }

        $candidates = $query->latest()->get();

        return view('candidates.index', compact('user', 'candidates'));
    }

    public function create(): View
    {
        $user = auth()->user();

        return view('candidates.create', $this->formData($user));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $instituteId = $this->resolveInstituteId($request, $user);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'institute_id' => $user->role === 'admin'
                ? ['required', 'exists:institutes,id']
                : ['required', Rule::in([(string) $instituteId])],
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where(fn ($courseQuery) => $courseQuery->where('institute_id', $instituteId)),
            ],
        ]);

        Candidate::create([
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'institute_id' => $instituteId,
            'course_id' => $request->input('course_id'),
            'created_by' => $user->id,
        ]);

        return redirect()->route('candidates.index')->with('success', 'Candidate created successfully.');
    }

    public function edit(Candidate $candidate): View
    {
        $user = auth()->user();
        $this->authorizeCandidateAccess($user, $candidate);

        return view('candidates.edit', $this->formData($user, $candidate));
    }

    public function update(Request $request, Candidate $candidate): RedirectResponse
    {
        $user = auth()->user();
        $this->authorizeCandidateAccess($user, $candidate);

        $instituteId = $this->resolveInstituteId($request, $user, $candidate);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'institute_id' => $user->role === 'admin'
                ? ['required', 'exists:institutes,id']
                : ['required', Rule::in([(string) $instituteId])],
            'course_id' => [
                'required',
                Rule::exists('courses', 'id')->where(fn ($courseQuery) => $courseQuery->where('institute_id', $instituteId)),
            ],
        ]);

        $candidate->update([
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'email' => $request->input('email'),
            'institute_id' => $instituteId,
            'course_id' => $request->input('course_id'),
        ]);

        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy(Candidate $candidate): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($user->role === 'admin', 403, 'Unauthorized');

        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }

    private function formData(User $user, ?Candidate $candidate = null): array
    {
        if ($user->role === 'admin') {
            $institutes = Institute::orderBy('name')->get();
            $courses = Course::withoutGlobalScope(TenantScope::class)
                ->with('institute')
                ->orderBy('course_name')
                ->get();
        } else {
            $institutes = collect($user->institute ? [$user->institute] : []);
            $courses = Course::with('institute')
                ->orderBy('course_name')
                ->get();
        }

        $selectedInstituteId = old(
            'institute_id',
            $candidate?->institute_id ?? ($user->role === 'admin' ? session('selected_institute_id') : $user->institute_id)
        );

        return [
            'user' => $user,
            'candidate' => $candidate,
            'institutes' => $institutes,
            'courses' => $courses,
            'selectedInstituteId' => $selectedInstituteId,
        ];
    }

    private function resolveInstituteId(Request $request, User $user, ?Candidate $candidate = null): int
    {
        if ($user->role === 'admin') {
            return (int) $request->input('institute_id');
        }

        return (int) ($candidate?->institute_id ?? $user->institute_id);
    }

    private function authorizeCandidateAccess(User $user, Candidate $candidate): void
    {
        if ($user->role === 'admin') {
            return;
        }

        abort_unless($candidate->created_by === $user->id, 403, 'Unauthorized');
    }
}
