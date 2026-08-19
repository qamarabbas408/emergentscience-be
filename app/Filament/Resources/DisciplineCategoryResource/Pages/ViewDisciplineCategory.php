<?php

namespace App\Filament\Resources\DisciplineCategoryResource\Pages;

use App\Filament\Resources\DisciplineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDisciplineCategory extends ViewRecord
{
    protected static string $resource = DisciplineCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
