<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'major_id',
        'name',
        'level',
        'is_active'
    ];

    public function major ()
    {
        return $this->belongsTo(Major::class);      
    }

    public function student ()
    {
        return $this->belongsTo(Student::class);      
    }

}
