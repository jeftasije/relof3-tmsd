<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'template_id',
        'content',
        'is_active',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
