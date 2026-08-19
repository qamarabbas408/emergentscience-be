<?php

namespace App\Filament\Resources\DisciplineCategoryResource\Pages;

use App\Filament\Resources\DisciplineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDisciplineCategories extends ListRecords
{
    protected static string $resource = DisciplineCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
