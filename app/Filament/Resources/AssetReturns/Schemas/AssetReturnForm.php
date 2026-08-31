<?php

namespace App\Filament\Resources\AssetReturns\Schemas;

use App\Models\Ticket;
use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AssetReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ticket_id')
                    ->required()
                    ->label('Ticket Number')
                    ->relationship('ticket','ticket_number', function($query, $operation, $record){
                        if($operation === 'create'){
                            return $query->where('status','verifying');
                        }
                        return $query;
                    })
                    ->disabled(fn($operation) => $operation === 'edit')
                    ->dehydrated()
                    ->afterStateUpdated(fn($state, $set)=>
                    $set('asset_id', Ticket::find($state)?->asset_id))
                    ->live(),
                Select::make('user_id')
                    ->required()
                    ->label('Verified By')
                    ->relationship('user','name')
                    ->default(Auth::id())
                    ->hidden()
                    ->dehydrated(),
                Select::make('asset_id')
                    ->required()
                    ->label('Asset Name')
                    ->relationship('asset','name')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('qty')
                    ->required()
                    ->numeric()
                    ->default(fn(callable $get)=>Ticket::find($get('ticket_id'))?->qty ?? 1)
                    ->readOnly(),
                Select::make('condition')
                    ->options(['good' => 'Good', 'damaged' => 'Damaged', 'lost' => 'Lost'])
                    ->default('good')
                    ->required(),
                DateTimePicker::make('returned_at')
                    ->required()
                    ->default(Carbon::now())
                    ->hidden()
                    ->dehydrated(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
