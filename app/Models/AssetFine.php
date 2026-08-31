<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class AssetFine extends Model
{
     use LogsActivity;

    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll()
        ->logOnlyDirty();
    }
    protected $fillable = [
        'asset_return_id',
        'amount',
        'type',
        'notes'
    ];

    public function assetReturn()
    {
        return $this->belongsTo(AssetReturn::class);
    }
}
