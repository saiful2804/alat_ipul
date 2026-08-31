<?php

namespace App\Filament\Resources\Classrooms\Schemas;

use App\Models\Major;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClassroomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('major_id')
                    ->required()
                    ->label('Major')
                    ->relationship('major','name')
                    ->options(Major::where('is_active', true)->pluck('name','id')),
                TextInput::make('name')
                    ->required(),
                Select::make('level')
                    ->required()
                    ->label('Grade')
                    ->options([
                        10 => 'Grade X',
                        11 => 'Grade XI',
                        12 => 'Grade XII',
                    ]),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
