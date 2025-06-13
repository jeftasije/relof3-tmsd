<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtendedNews extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'content',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
