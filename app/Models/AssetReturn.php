<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class AssetReturn extends Model
{
     use LogsActivity;

    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logAll()
        ->logOnlyDirty();
    }
    protected $fillable = [
        'user_id',
        'asset_id',
        'ticket_id',
        'qty',
        'condition',
        'notes',
        'returned_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    protected static function booted()
    {
        static::creating(function(AssetReturn $return){
            if (Auth::check()){
                $return->user_id ??= Auth::id();
            }
            $return->returned_at ??= now();
        });

        static::creating(function(AssetReturn $return){
            if ($return->ticket){
                $return->ticket->update([
                    'status' => 'returned',
                    'returned_at' => $return->returned_at
                ]);
            }
        });
    }

    public function assetFines()
    {
        return $this->hasMany(AssetFine::class);
    }

    protected $casts = [
        'due_at' => 'date',
        'returned_at' => 'datetime',
    ];
}
