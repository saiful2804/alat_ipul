<?php

namespace App\Filament\Resources\AssetReturns;

use App\Filament\Resources\AssetReturns\Pages\CreateAssetReturn;
use App\Filament\Resources\AssetReturns\Pages\EditAssetReturn;
use App\Filament\Resources\AssetReturns\Pages\ListAssetReturns;
use App\Filament\Resources\AssetReturns\Pages\ViewAssetReturn;
use App\Filament\Resources\AssetReturns\RelationManagers\AssetFinesRelationManager;
use App\Filament\Resources\AssetReturns\Schemas\AssetReturnForm;
use App\Filament\Resources\AssetReturns\Schemas\AssetReturnInfolist;
use App\Filament\Resources\AssetReturns\Tables\AssetReturnsTable;
use App\Models\AssetReturn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssetReturnResource extends Resource
{
    protected static ?string $model = AssetReturn::class;

   protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static string|BackedEnum|null $activeNavigationIcon = 'heroicon-s-clipboard-document-check';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return AssetReturnForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssetReturnInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssetReturnsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AssetFinesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssetReturns::route('/'),
            'create' => CreateAssetReturn::route('/create'),
            'view' => ViewAssetReturn::route('/{record}'),
            'edit' => EditAssetReturn::route('/{record}/edit'),
        ];
    }
}
