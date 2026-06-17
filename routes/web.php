<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\AdmissionController;

use App\Models\Candidate;
use App\Models\Institute;
use App\Models\User;
use App\Models\Course;
use App\Scopes\TenantScope;

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| AUTH + TENANT
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/dashboard', function () {

        $user = auth()->user();
        $selectedInstituteId = session('selected_institute_id');

        $institute = $user->role === 'admin' && $selectedInstituteId
            ? Institute::find($selectedInstituteId)
            : $user->institute;

        if ($user->role === 'admin') {

            $users = User::with('institute')->get();
            $courses = Course::with('institute')->get();

            $candidates = Candidate::with([
                'institute',
                'createdBy',
                'course' => fn ($q) => $q->withoutGlobalScope(TenantScope::class),
            ])->latest()->get();

            return view('admin.dashboard', compact(
                'user',
                'institute',
                'users',
                'courses',
                'candidates'
            ));
        }

        if ($user->role === 'manager') {

            $employees = User::where('role', 'employee')
                ->where('institute_id', $user->institute_id)
                ->get();

            $candidates = Candidate::with([
                'institute',
                'createdBy',
                'course',
            ])
            ->where('created_by', $user->id)
            ->latest()
            ->get();

            return view('manager.dashboard', compact(
                'user',
                'employees',
                'candidates'
            ));
        }

        $candidates = Candidate::with([
            'institute',
            'createdBy',
            'course',
        ])
        ->where('created_by', $user->id)
        ->latest()
        ->get();

        return view('employee.dashboard', compact('user', 'candidates'));

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | TENANT SWITCH
    |--------------------------------------------------------------------------
    */

    Route::post('/tenant/switch', [InstituteController::class, 'switchInstitute'])
        ->name('tenant.switch');

    Route::get('/institutes', [InstituteController::class, 'index'])
        ->name('institutes.index');

    Route::get('/institutes/{institute}', [InstituteController::class, 'show'])
        ->whereNumber('institute')
        ->name('institutes.show');

});

/*
|--------------------------------------------------------------------------
| ADMIN + MANAGER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant', 'role:admin,manager'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users/store', [AdminController::class, 'store'])->name('users.store');

        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('delete');
    });

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant', 'role:admin'])->group(function () {

    Route::get('/institutes/create', [InstituteController::class, 'create'])
        ->name('institutes.create');

    Route::post('/institutes', [InstituteController::class, 'store'])
        ->name('institutes.store');
});

/*
|--------------------------------------------------------------------------
| COURSES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant', 'role:admin,manager'])->group(function () {

    Route::post('/institutes/{institute}/courses',
        [InstituteController::class, 'storeCourse']
    )->name('institutes.courses.store');
});

/*
|--------------------------------------------------------------------------
| CANDIDATES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant', 'role:admin,manager,employee'])->group(function () {

    Route::resource('candidates', CandidateController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| ADMISSIONS (FIXED + CLEAN AJAX ROUTE)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'tenant', 'role:admin,manager,employee'])->group(function () {

    Route::resource('admissions', AdmissionController::class);

    // AJAX route (ONLY ONE)
   
});
 Route::get('/candidate-details/{id}', [AdmissionController::class, 'getCandidate'])
        ->name('candidate.details');