<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_en',
        'title_cy',
        'summary',
        'summary_en',
        'summary_cy',
        'image_path',
        'author',
        'published_at',
    ];

    protected $dates = [
        'published_at',
    ];

    public function extended()
    {
        return $this->hasOne(ExtendedNews::class);
    }

    public function translate(string $field): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $fieldName = $field . '_en';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $fieldName = $field . '_cy';
        } else {
            $fieldName = $field;
        }

        return $this->{$fieldName} ?? $this->{$field} ?? '';
    }
}