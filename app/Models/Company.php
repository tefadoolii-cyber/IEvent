<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'commercial_register', 'contact_person',
        'phone', 'email', 'city', 'address', 'is_active', 'notes',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
