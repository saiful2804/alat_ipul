<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('total_qty')
                    ->numeric(),
                TextEntry::make('good_qty')
                    ->numeric(),
                TextEntry::make('damaged_qty')
                    ->numeric(),
                TextEntry::make('borrowed_qty')
                    ->numeric(),
                TextEntry::make('lost_qty')
                    ->numeric(),
                IconEntry::make('is_available')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
