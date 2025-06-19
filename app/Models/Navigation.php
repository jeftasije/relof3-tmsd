<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'name_en',
        'is_deletable',
        'redirect_url',
    ];

    public function children()
    {
        return $this->hasMany(Navigation::class, 'parent_id');
    }

    public function translate(string $field): string
    {
        $locale = app()->getLocale();
        $fieldName = $field . ($locale === 'en' ? '_en' : '');

        return $this->{$fieldName} ?? $this->{$field} ?? '';
    }
}