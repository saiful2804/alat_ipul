<?php

namespace App\Filament\Resources\AssetReturns\Pages;

use App\Filament\Resources\AssetReturns\AssetReturnResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAssetReturn extends ViewRecord
{
    protected static string $resource = AssetReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
