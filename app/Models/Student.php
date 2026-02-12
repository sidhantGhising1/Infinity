<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student',
        'email',
        'profile_image',
        'course',
        'applied_university',
        'status',
        'application',
        'counselor',
    ];


    
}
