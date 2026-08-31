<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

            Section::make('Profile Picture')
            ->schema([
                ImageEntry::make('profile_picture')
                    ->disk('public')
                    ->imageHeight(300)
                    ->hiddenLabel()
                    ->alignCenter(),
            ])->columnSpan(1),
            Section::make('Student Information')
            ->schema([
                TextEntry::make('user.name')
                    ->label('Student Name')
                    ->icon(Heroicon::UserCircle),
                TextEntry::make('nisn')
                    ->label('NISN')
                    ->icon(Heroicon::Identification),
                TextEntry::make('classroom.name')
                    ->label('Class')
                    ->icon(Heroicon::BuildingOffice),
                TextEntry::make('gender')
                    ->label('Gender')
                    ->badge(),
                TextEntry::make('phone_number')
                    ->label('Phone Number')
                    ->icon(Heroicon::Phone),
                TextEntry::make('address')
                    ->label('Address')
                    ->icon(Heroicon::MapPin),
            ])->columnSpan(2)
            ->columns(3),
        ])->columns(3);
    }
}
