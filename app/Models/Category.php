<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'is_active'
    ];

    public function assets()
    {
        return $this->belongsTo(Asset::class);
    }
}
