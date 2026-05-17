<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetAssignment extends Model
{
    protected $fillable = [
        'asset_id', 'employee_id', 'assigned_by',
        'delivered_at', 'returned_at', 'notes',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'returned_at'  => 'datetime',
    ];

    public function asset()    { return $this->belongsTo(Asset::class); }
    public function employee() { return $this->belongsTo(Employee::class); }
    public function assignedBy() { return $this->belongsTo(User::class, 'assigned_by'); }

    public function isActive(): bool
    {
        return is_null($this->returned_at);
    }
}
