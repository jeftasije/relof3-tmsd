<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $fillable = [
        'parent_id',
        'naziv',
        'is_deletable'
    ];

    public function children()
    {
        return $this->hasMany(Navigation::class, 'parent_id');
    }
}
