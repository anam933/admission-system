<?php

namespace App\Http\Middleware;

use App\Models\Institute;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            $selectedInstituteId = session('selected_institute_id');

            if ($selectedInstituteId && ! Institute::where('id', $selectedInstituteId)->exists()) {
                session()->forget('selected_institute_id');
            }
        } else {
            session(['selected_institute_id' => $user->institute_id]);
        }

        view()->share('currentInstituteId', session('selected_institute_id'));

        return $next($request);
    }
}
