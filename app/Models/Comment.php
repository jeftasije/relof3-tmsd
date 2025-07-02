<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name', 'comment', 'comment_lat', 'comment_cy', 'comment_en', 'parent_id', 'is_official'];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function translate(string $field): string
    {
        $locale = app()->getLocale();
        if ($locale === 'en') {
            $fieldName = $field . '_en';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $fieldName = $field . '_cy';
        } else {
            $fieldName = $field . '_lat';
        }
        return $this->{$fieldName} ?? $this->{$field} ?? '';
    }
}
