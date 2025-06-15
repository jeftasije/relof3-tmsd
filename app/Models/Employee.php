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
        'biography',
        'biography_en',
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
        return $locale === 'en' ? ($this->position_en ?? $this->position) : $this->position;
    }

    public function getTranslatedBiographyAttribute()
    {
        $locale = App::getLocale();
        return $locale === 'en' ? ($this->biography_en ?? $this->biography) : $this->biography;
    }

    public function translate(string $field): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $translatedField = $field . '_en';

            return $this->{$translatedField} ?? $this->{$field};
        }

        return $this->{$field};
    }
}