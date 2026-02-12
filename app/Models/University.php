<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'logo',
        'university_name',
        'country',
        'city',
        'partner_type',
        'programs',
        'application_fee',
        'status',
    ];
}
