<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    protected $fillable = [
        'table_name',
        'field_key',
        'field_label',
        'field_type',
        'options',
        'is_required',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active'   => 'boolean',
    ];

    // جلب الحقول المخصصة لجدول معين
    public static function forTable($tableName)
    {
        return self::where('table_name', $tableName)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}
