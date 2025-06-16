<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendedBiography extends Model
{
    protected $fillable = [
        'employee_id',
        'biography',
        'biography_translated',
        'university',
        'university_translated',
        'experience',
        'experience_translated',
        'skills',
        'skills_translated',
    ];

    protected $casts = [
        'skills' => 'array',
        'skills_translated' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function translate(string $field)
    {
        $locale = app()->getLocale();
        $translatedField = $field . '_translated';

        if (is_array($this->{$translatedField})) {
            return $this->{$translatedField}[$locale] ?? $this->{$field};
        }

        if (is_string($this->{$translatedField})) {
            return $locale === 'en' && !empty($this->{$translatedField})
                ? $this->{$translatedField}
                : $this->{$field};
        }

        return $this->{$field};
    }

}