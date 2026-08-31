<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lending Transaction')
                ->description('menetapkan aset kepada pemohon dan menentukan tanggal pengembalian yang diharapkan')
                ->schema([
                Select::make('user_id')
                    ->required()
                    ->label('Requester')
                    ->relationship('user','name'),
                Select::make('asset_id')
                    ->required()
                    ->label('Asset Name')
                    ->relationship('asset','name'),
                DatePicker::make('due_at')
                ->label('Due Date'),
                Textarea::make('note')
                ->label('Additional Notes')
                ->columnSpanFull()
                ])->columns(3)
                ->columnSpanFull(),
                
            ]);
    }
}
