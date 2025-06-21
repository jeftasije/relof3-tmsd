<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendedBiography extends Model
{
    protected $fillable = [
        'employee_id',
        'biography',
        'biography_translated',   
        'biography_cy',          
        'university',
        'university_translated',  
        'university_cy',          
        'experience',
        'experience_translated',  
        'experience_cy',         
        'skills',
        'skills_translated',      
        'skills_cy',             
    ];

    protected $casts = [
        'skills' => 'array',
        'skills_translated' => 'array',
        'skills_cy' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function translate(string $field)
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $translatedField = $field . '_translated';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $translatedField = $field . '_cy';
        } else {
            $translatedField = $field;
        }

        if (isset($this->{$translatedField}) && !empty($this->{$translatedField})) {
            return $this->{$translatedField};
        }

        return $this->{$field};
    }
}
