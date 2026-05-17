<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'model_type', 'model_id', 'type_id', 'created_by', 'note', 'severity',
    ];

    public function noteType()  { return $this->belongsTo(Lookup::class, 'type_id'); }
    public function creator()   { return $this->belongsTo(User::class, 'created_by'); }

    public function notable()
    {
        return $this->morphTo('model');
    }

    public function getSeverityLabelAttribute(): string
    {
        return match($this->severity) {
            'info'     => 'معلومة',
            'warning'  => 'تحذير',
            'critical' => 'حرج',
            default    => $this->severity,
        };
    }

    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'info'     => '#2563eb',
            'warning'  => '#d97706',
            'critical' => '#dc2626',
            default    => '#6b7280',
        };
    }
}
