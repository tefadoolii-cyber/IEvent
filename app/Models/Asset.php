<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name', 'type', 'serial_number', 'model', 'brand',
        'status', 'notes', 'purchase_date', 'purchase_price',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function assignments()
    {
        return $this->hasMany(AssetAssignment::class);
    }

    public function currentAssignment()
    {
        return $this->hasOne(AssetAssignment::class)->whereNull('returned_at')->latest();
    }

    public function currentEmployee()
    {
        return $this->hasOneThrough(Employee::class, AssetAssignment::class, 'asset_id', 'id', 'id', 'employee_id')
                    ->whereNull('asset_assignments.returned_at');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available'   => 'متاح',
            'assigned'    => 'مُسلَّم',
            'maintenance' => 'صيانة',
            'retired'     => 'مُهلَك',
            default       => $this->status,
        };
    }
}
