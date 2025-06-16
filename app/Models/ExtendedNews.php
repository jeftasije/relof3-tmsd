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
        'tags',
        'tags_en',
    ];

    protected $casts = [
        'tags' => 'array',
        'tags_en' => 'array',
    ];

    public function translate(string $field, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $fieldName = $field;

        if ($locale === 'en') {
            $fieldName = $field . '_en';
        }

        return $this->{$fieldName} ?? $this->{$field} ?? null;
    }

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
