<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendedBiography extends Model
{
    protected $fillable = ['employee_id', 'biography', 'university', 'experience', 'skills'];

    protected $casts = [
        'skills' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}