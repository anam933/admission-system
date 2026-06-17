<?php

namespace App\Providers;

use App\Models\Institute;
use App\Scopes\TenantScope;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = auth()->user();
            $selectedInstituteId = session('selected_institute_id');
            $currentInstitute = null;
            $availableInstitutes = collect();

            if ($user) {
                if ($user->role === 'admin') {
                    $currentInstitute = $selectedInstituteId ? Institute::find($selectedInstituteId) : null;
                    $availableInstitutes = Institute::all();
                } else {
                    $currentInstitute = $user->institute;
                }
            }

            $view->with('currentInstitute', $currentInstitute)
                 ->with('availableInstitutes', $availableInstitutes)
                 ->with('currentTenantId', TenantScope::currentTenantId());
        });
    }
}
