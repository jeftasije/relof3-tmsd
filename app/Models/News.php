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
        'summary',
        'summary_en',
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
        $fieldName = $field . ($locale === 'en' ? '_en' : '');

        return $this->{$fieldName} ?? $this->{$field} ?? '';
    }
}
