<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = [

        'name',
        'code',
        'is_active'
    ];

    public function classes ()
    {
        return $this->hasMany(Classroom::class);      
    }
}
