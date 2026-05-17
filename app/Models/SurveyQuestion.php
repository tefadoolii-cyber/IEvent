<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $fillable = ['survey_id', 'question', 'type', 'options', 'required', 'order'];

    protected $casts = ['options' => 'array', 'required' => 'boolean'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'text'            => 'نص حر',
            'rating'          => 'تقييم',
            'single_choice'   => 'اختيار واحد',
            'multiple_choice' => 'اختيار متعدد',
            default           => $this->type,
        };
    }
}
