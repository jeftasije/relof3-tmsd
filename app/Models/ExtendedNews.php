<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtendedNews extends Model
{
    use HasFactory;

    protected $table = 'extended_news';

    protected $fillable = [
        'news_id',
        'content',
        'content_en',
        'content_cy',
        'tags',
        'tags_en',
        'tags_cy',
    ];

    protected $casts = [
        'tags' => 'array',
        'tags_en' => 'array',
        'tags_cy' => 'array',
    ];

    public function translate(string $field, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'en') {
            $fieldName = $field . '_en';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $fieldName = $field . '_cy';
        } else {
            $fieldName = $field;
        }

        return $this->{$fieldName} ?? $this->{$field} ?? null;
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}