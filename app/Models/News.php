<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'summary',
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
}
