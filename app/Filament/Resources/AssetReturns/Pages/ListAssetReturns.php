<?php

namespace App\Filament\Resources\AssetReturns\Pages;

use App\Filament\Resources\AssetReturns\AssetReturnResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssetReturns extends ListRecords
{
    protected static string $resource = AssetReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
