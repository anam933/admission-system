<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Scopes\TenantScope;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InstituteController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $institutes = Institute::withCount([
                'courses' => fn ($query) => $query->withoutGlobalScope(TenantScope::class),
            ])->orderBy('name')->get();
            $selectedInstituteId = session('selected_institute_id');
            $selectedInstitute = $selectedInstituteId
                ? $institutes->firstWhere('id', (int) $selectedInstituteId)
                : null;
        } elseif ($user->institute_id) {
            $institutes = Institute::withCount('courses')->where('id', $user->institute_id)->get();
            $selectedInstitute = $institutes->first();
        } else {
            $institutes = collect();
            $selectedInstitute = null;
        }

        return view('institutes.index', compact('institutes', 'selectedInstitute'));
    }

    public function create(): View
    {
        return view('institutes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:institutes,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Institute::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('institutes.index')->with('success', 'Institute created successfully.');
    }

    public function switchInstitute(Request $request): RedirectResponse
    {
        $request->validate([
            'institute_id' => 'nullable|exists:institutes,id',
        ]);

        $user = Auth::user();

        if ($user->role !== 'admin' && (int) $request->input('institute_id') !== (int) $user->institute_id) {
            abort(403, 'Unauthorized');
        }

        if ($request->filled('institute_id')) {
            session(['selected_institute_id' => $request->input('institute_id')]);
        } else {
            session()->forget('selected_institute_id');
        }

        return redirect()->route('institutes.index')->with('success', 'Institute filter updated.');
    }

    public function show(Institute $institute): View
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->institute_id !== $institute->id) {
            abort(403, 'Unauthorized');
        }

        if ($user->role === 'admin') {
            $institute->load([
                'courses' => fn ($query) => $query->withoutGlobalScope(TenantScope::class),
            ]);
        } else {
            $institute->load('courses');
        }

        return view('institutes.show', compact('institute'));
    }

    public function storeCourse(Request $request, Institute $institute): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === 'employee') {
            abort(403, 'Unauthorized');
        }

        if ($user->role === 'manager' && $user->institute_id !== $institute->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'course_name' => 'required|string|max:255',
            'amount' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $institute->courses()->create([
            'course_name' => $request->input('course_name'),
            'amount' => $request->input('amount'),
            'duration' => $request->input('duration'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('institutes.show', $institute)->with('success', 'Course added to institute successfully.');
    }
}
