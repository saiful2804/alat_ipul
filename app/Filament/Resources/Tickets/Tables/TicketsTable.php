<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Models\AssetFine;
use App\Models\AssetReturn;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;


class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Ticket')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Requester')
                    ->sortable(),
                TextColumn::make('asset.name')
                    ->label('Asset Name')
                    ->sortable(),
                TextColumn::make('qty')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('booked_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('borrowed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('due_at')
                    ->date()
                    ->sortable()
                    ->icon('heroicon-m-flag')
                    ->iconColor(function ($record){
                        if(in_array($record->status,['booked','cancelled']) || !$record->due_at) return null;

                        $isOverdue = $record->due_at->startOfDay()->isPast();
                        $isLateReturn = $record->status === 'returned' && $record->returned_at?->startOfDay()->gt($record->due_at->startOfDay());

                        return match(true){
                            $record->status === 'returned' => $isLateReturn ? 'warning' : 'success',
                            in_array($record->status,['borrowed','verifying']) => $isOverdue ? 'danger' : 'success',
                            default => null,
                        };
                    })
                    ->description(function($record){
                        if(in_array($record->status,['booked','cancelled']) || !$record->due_at) return null;

                        $due = $record->due_at->startOfDay();
                        $now = now()->startOfDay();
                        $return = $record->returned_at?->startOfDay();

                        if ($record->status === 'returned' && $return){
                            $diff = $due->diffInDays($return, false);
                            return $diff > 0 ? "Returned late by {$diff} days" : "Returned on time.";
                        }

                        $diff = $now->diffInDays($due, false);
                        return match(true){
                            $diff < 0 => "Overdue By " .abs($diff) . " days.",
                            $diff == 0 => 'Due Today!',
                            default => "{$diff} days remaining"
                        };
                    }),
                TextColumn::make('returned_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(fn(string $state): string=>match($state){
                    'booked' => 'Reserved',
                    'borrowed' => 'On Loan',
                    'verifying' => 'Review',
                    'returned' => 'Returned',
                    'cancelled' => 'Cancelled',
                    default => ucfirst($state)
                })
                ->color(fn(string $state): string=>match($state){
                    'booked' => 'info',
                    'borrowed' => 'success',
                    'verifying' => 'warning',
                    'returned' => 'success',
                    'cancelled' => 'danger',
                    
                }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('approveBorrowing')
                ->label('Approve')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn($record) => $record->status === 'booked')
                ->action(fn($record) => $record->update([
                    'status' => 'borrowed',
                    'borrowed_at' => now(),
                ]))->button(),
                Action::make('cancelBorrowing')
                ->label('Reject')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn($record) => $record->status === 'booked')
                ->action(fn($record) => $record->update([
                    'status' => 'cancelled',
                ]))->button(),
                Action::make('verifyReturn')
                ->label('Return')
                ->color('info')
                ->requiresConfirmation()
                ->visible(fn($record) => $record->status === 'borrowed')
                ->action(fn($record) => $record->update([
                    'status' => 'verifying',
                ]))->button(),
                ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                ]),
                Action::make('completed')
                ->label('Completed')
                ->color('success')
                ->visible(fn($record) => $record->status === 'verifying')
                ->schema([
                    Select::make('condition')
                    ->label('Asset Condition')
                    ->required()
                    ->options([
                        'good' => 'Good',
                        'damaged' => 'Broken',
                        'lost' => 'Lost'
                    ])->default('good'),
                    Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
                ])
                ->action(function($record, array $data){
                    
                    DB::transaction(function () use ($record, $data){
                        $returnTime = now();
                        $qty = $record->qty;
                        $asset = $record->asset;
                        $price = $asset?->purchase_price ?? 0;

                        //update tiket
                        $record->update([
                            'status' => 'returned',
                            'returned_at' => $returnTime,
                        ]);

                        //create asset return
                        $assetReturn = AssetReturn::create([
                            'user_id' => $record->user_id,
                            'asset_id' => $record->asset_id,
                            'ticket_id' => $record->id,
                            'qty' => $qty ,
                            'condition' => $data['condition'],
                            'notes' => $data['notes'] ?? null,
                            'returned_at' => $returnTime
                        ]);

                        //late fine

                        $lateDays = $record->due_at?->startOfDay()->diffInDays($returnTime->startOfDay(), false) ;

                        if ($lateDays > 0){
                            AssetFine::create([
                                'asset_return_id' => $assetReturn->id,
                                'type' => 'late',
                                'amount' => ($price * $qty * 0.01) * $lateDays,
                                'notes' => "Late {$lateDays} days",
                            ]);
                        }

                        //condition fine

                        $fineRates = [
                            'damaged' => ['type' => 'damage', 'rate' => 0.30],
                            'lost' => ['type' => 'lost', 'rate' => 1],
                        ];

                        if(isset($fineRates[$data['condition']])){
                            $fine = $fineRates[$data['condition']];

                            AssetFine::create([
                                'asset_return_id' => $assetReturn->id,
                                'type' => $fine['type'],
                                'amount' => ($price * $qty) * $fine['rate'],
                                'notes' => 'Asset' . ucfirst($data['condition']),
                            ]);
                        }
                    });
                })->modalHeading('Asset Return')
                ->modalSubmitActionLabel('Confirm Return')
                ->modalWidth('md')
                ->button(),
        
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
