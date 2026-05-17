<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'model_type', 'model_id', 'approver_id', 'withdrawn_by',
        'status', 'reason', 'approved_at', 'withdrawn_at',
    ];

    protected $casts = [
        'approved_at'  => 'datetime',
        'withdrawn_at' => 'datetime',
    ];

    public function approver()   { return $this->belongsTo(User::class, 'approver_id'); }
    public function withdrawer() { return $this->belongsTo(User::class, 'withdrawn_by'); }

    public function approvable()
    {
        return $this->morphTo('model');
    }
}
