<?php

namespace App\Filament\Resources\ActivityLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Information')
                ->schema([
                    TextEntry::make('causer.name')
                ->label('User'),
                TextEntry::make('description')
                ->label('Action'),
                TextEntry::make('subject_type')
                ->label('Model')
                ->formatStateUsing(fn($state) => class_basename($state)),
                TextEntry::make('subject_id')
                ->label('ID'),
                TextEntry::make('created_at')
                ->dateTime()
                ]),
            ]);
    }
}
