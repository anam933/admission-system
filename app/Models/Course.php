<?php

namespace App\Models;

use App\Models\Candidate;
use App\Models\Institute;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'institute_id',
        'course_name',
        'amount',
        'duration',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
