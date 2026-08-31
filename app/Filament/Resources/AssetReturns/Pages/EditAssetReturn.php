<?php

namespace App\Filament\Resources\AssetReturns\Pages;

use App\Filament\Resources\AssetReturns\AssetReturnResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAssetReturn extends EditRecord
{
    protected static string $resource = AssetReturnResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
