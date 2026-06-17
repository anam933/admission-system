<?php

namespace App\Models;

use App\Models\Candidate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = ['name', 'description'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
