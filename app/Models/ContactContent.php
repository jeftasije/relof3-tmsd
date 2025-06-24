<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactContent extends Model
{
    protected $fillable = [
        'text_sr',
        'text_en',
        'text_cy',
    ];
}
