<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    protected $fillable = [
        'name',
        'name_en',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id');
    }

    public function translate(string $field): string
    {
        $locale = app()->getLocale();
        $fieldName = $field . ($locale === 'en' ? '_en' : '');

        return $this->{$fieldName} ?? $this->{$field} ?? '';
    }
}
