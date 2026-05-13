<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'employee_number',
        'phone',
        'email',
        'department',
        'position',
        'status',
        'start_date',
        'end_date',
        'contract_status',
    ];
}