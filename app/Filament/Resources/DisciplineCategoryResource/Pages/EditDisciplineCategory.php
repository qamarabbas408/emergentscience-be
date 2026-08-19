<?php

namespace App\Filament\Resources\DisciplineCategoryResource\Pages;

use App\Filament\Resources\DisciplineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDisciplineCategory extends EditRecord
{
    protected static string $resource = DisciplineCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
