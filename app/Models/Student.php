<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 
        'classroom_id',
        'nisn',
        'phone_number',
        'gender',
        'address',
        'profile_picture'
    ];

    public function user (){

    return $this->belongsTo(User::class);
    }

    public function classroom (){

    return $this->belongsTo(Classroom::class);
    }
    
}
