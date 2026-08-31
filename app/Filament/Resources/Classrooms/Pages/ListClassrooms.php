<?php

namespace App\Filament\Resources\Classrooms\Pages;

use App\Filament\Resources\Classrooms\ClassroomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListClassrooms extends ListRecords
{
    protected static string $resource = ClassroomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return[
            'all' => Tab::make(),
            'grade_10' => Tab::make('Grade X')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 10)),
            'grade_11' => Tab::make('Grade XI')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 11)),
            'grade_12' => Tab::make('Grade XII')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('level', 12)),
        ];
    }
}
