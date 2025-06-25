<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
        protected $fillable = [
        'title_en',
        'title_cyr',
        'title_lat',
        'time'
    ];
}
