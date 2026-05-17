<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'company_id', 'price', 'description', 'services', 'status'];

    protected $casts = ['services' => 'array', 'price' => 'decimal:2'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'active' ? 'نشط' : 'غير نشط';
    }
}
