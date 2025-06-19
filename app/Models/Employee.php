<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'position',
        'position_en',
        'position_cy',
        'biography',
        'biography_en',
        'biography_cy',
        'image_path',
    ];

    protected $casts = [
        'biography' => 'string',
    ];

    protected $appends = [
        'translated_position',
        'translated_biography',
    ];

    public function extendedBiography()
    {
        return $this->hasOne(ExtendedBiography::class);
    }

    public function getTranslatedPositionAttribute()
    {
        $locale = App::getLocale();
        if ($locale === 'en') {
            return $this->position_en ?? $this->position;
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            return $this->position_cy ?? $this->position;
        }
        return $this->position;
    }

    public function getTranslatedBiographyAttribute()
    {
        $locale = App::getLocale();
        if ($locale === 'en') {
            return $this->biography_en ?? $this->biography;
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            return $this->biography_cy ?? $this->biography;
        }
        return $this->biography;
    }

    public function translate(string $field): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $translatedField = $field . '_en';
            return $this->{$translatedField} ?? $this->{$field};
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $translatedField = $field . '_cy';
            return $this->{$translatedField} ?? $this->{$field};
        }
        return $this->{$field};
    }
}
