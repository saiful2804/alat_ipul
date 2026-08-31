<?php

namespace App\Filament\Resources\AssetReturns\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class AssetFinesRelationManager extends RelationManager
{
    protected static string $relationship = 'assetFines';
    protected static ?string $title = 'Asset Fines';
    protected static ?string $recordTitleAttribute = 'type';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Fine Type')
                    ->required()
                    ->options([
                        'late' => 'Late Return',
                        'damage' => 'Damage',
                        'lost' => 'Lost'
                    ])
                    ->live()
                    ->afterStateUpdated(function($state, $set, $livewire){
                        $record = $livewire->ownerRecord;
                        $ticket = $record->ticket;

                        if(!$state || !$ticket) return;
                        if($state === 'lost'){
                            $set('amount', $ticket->asset?->purchase_price ?? 0);
                            $set('notes','Charged 100% of purchase price due to asset loss.');
                        }

                        elseif($state === 'late'){
                            if(!$ticket->due_at) return;

                            $due = \Illuminate\Support\Carbon::parse($ticket->due_at)->startOfDay();
                            $returned = \Illuminate\Support\Carbon::parse($record->returned_at ?? now())->startOfDay();

                            if($returned->gt($due)){
                                $days = $due->diffInDays($returned);

                                $set('amount', $days * 10000);
                                $set('notes', "Late return by {$days}. Rate: IDR 10.000/Day.");

                            }
                            else{
                                $set('amount', 0);
                                $set('notes', 'No delay detected. Returned on time.'); 
                            }
                        }

                        elseif($state === 'damage'){
                            $set('amount', 0);
                            $set('notes', 'Please describe the damage and repair cost here.');
                        }
                    }),

                    TextInput::make('amount')
                    ->label('Fine Amount')
                    ->numeric()
                    ->prefix('IDR')
                    ->required(),

                    Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')
                    ->label('Fine Type')
                    ->badge()
                    ->color(fn(string $state): string => match($state){
                        'late' => 'success',
                        'damage' => 'warning',
                        'lost' => 'danger'
                    })
                    ->formatStateUsing(fn(string $state): string => match($state){
                        'late' => 'Good Condition',
                        'damage' => 'Broken',
                        'lost' => 'Missing'
                    }),

                    TextColumn::make('amount')
                    ->label('Fine Amount')
                    ->money('IDR'),

                    TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(30),

                    TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()

            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
