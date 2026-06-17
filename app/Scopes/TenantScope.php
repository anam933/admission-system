<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! auth()->check()) {
            return;
        }

        $user = auth()->user();
        $tenantId = null;

        if ($user->role === 'admin') {
            $tenantId = session('selected_institute_id');
        } else {
            $tenantId = $user->institute_id;
        }

        if ($tenantId !== null) {
            $builder->where($model->qualifyColumn('institute_id'), $tenantId);
        }
    }

    public static function currentTenantId(): ?int
    {
        if (! auth()->check()) {
            return null;
        }

        $user = auth()->user();

        return $user->role === 'admin'
            ? session('selected_institute_id')
            : $user->institute_id;
    }
}
