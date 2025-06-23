<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
        protected $fillable = [
        'title',
        'category_en',
        'category_cyr',
        'category_lat',
        'custom_category'
    ];
}
