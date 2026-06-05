<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Public Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Dashboard (Laravel default)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminController::class, 'users'])->name('users.index');

        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');

        Route::post('/users/store', [AdminController::class, 'store'])->name('users.store');

        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');

        Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');

        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('delete');
    });

/*
|--------------------------------------------------------------------------
| MANAGER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:manager'])
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {

        Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');

        Route::get('/edit/{id}', [ManagerController::class, 'edit'])->name('edit');

        Route::post('/update/{id}', [ManagerController::class, 'update'])->name('update');

        Route::delete('/delete/{id}', [ManagerController::class, 'destroy'])->name('delete');
    });

/*
|--------------------------------------------------------------------------
| EMPLOYEE ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:employee'])
    ->prefix('employee')
    ->name('employee.')
    ->group(function () {

        Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    });