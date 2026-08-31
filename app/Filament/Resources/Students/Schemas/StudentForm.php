<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Models\Student;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->required()
                    ->label('Student Name')
                    ->relationship('user','name', fn($query)=>$query->role('student'))
                    ->disableOptionWhen(fn($value)=> Student::where('user_id', $value)->exists())
                    ->createOptionForm([
                        TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord:true),
                Select::make('roles')
                ->relationship('roles','name')
                ->label('Role')
                ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                    ]),
                Select::make('classroom_id')
                    ->required()
                    ->label('Class')
                    ->relationship('classroom','name'),
                TextInput::make('nisn')
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->validationMessages(['unique' => 'The NISN has already been registered'])
                    ->label('NISN'),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Select::make('gender')
                    ->label('Gender')
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->required(),
                Textarea::make('address')
                ->label('Address')
                    ->columnSpanFull(),
                FileUpload::make('profile_picture')
                ->label('Profil Picture')
                ->directory('Students')
                ->disk('public')
                ->default(null),
            ]);
    }
}
