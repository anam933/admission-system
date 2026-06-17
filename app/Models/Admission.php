<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\TenantScope;

class Admission extends Model
{
    protected $fillable = [
    'candidate_id',
    'course_id',

    'name',
    'email',
    'phone',

    'total_fees',
    'paid_amount',
    'remaining_amount',

    'institute_id',
    'created_by',
    'status',
];

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}