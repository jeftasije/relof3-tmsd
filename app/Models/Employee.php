<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     * defines which fields from the form can be filled in mass (mass assignment). 
     * For example code Employee::create($request->all())
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
        'biography',
        'image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'biography' => 'string',
    ];

    public function extendedBiography()
    {
        return $this->hasOne(ExtendedBiography::class);
    }
}