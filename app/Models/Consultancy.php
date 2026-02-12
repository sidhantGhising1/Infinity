<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultancy extends Model
{
    protected $fillable = [
        'logo',
        'consultancy_name',
        'email',
        'phone',
        'country',
        'service_fee',
        'currency',
        'students',
        'status',
    ];
}
