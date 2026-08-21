<?php

namespace App\Filament\Resources\ArticleTypeResource\Pages;

use App\Filament\Resources\ArticleTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticleType extends EditRecord
{
    protected static string $resource = ArticleTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['file_requirements'] = $this->buildFileRequirements($data);

        return $data;
    }

    private function buildFileRequirements(array $data): array
    {
        $sections = ['manuscript', 'figures', 'supplementary'];

        $result = [];
        foreach ($sections as $section) {
            $result[$section] = [
                'enabled' => (bool) ($data["{$section}_enabled"] ?? false),
                'max_size_mb' => (int) ($data["{$section}_max_size_mb"] ?? 50),
                'extensions' => $data["{$section}_extensions"] ?? [],
            ];
            unset($data["{$section}_enabled"], $data["{$section}_max_size_mb"], $data["{$section}_extensions"]);
        }

        return $result;
    }
}
