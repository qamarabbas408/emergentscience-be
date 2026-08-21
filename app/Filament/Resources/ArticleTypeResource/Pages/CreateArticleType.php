<?php

namespace App\Filament\Resources\ArticleTypeResource\Pages;

use App\Filament\Resources\ArticleTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticleType extends CreateRecord
{
    protected static string $resource = ArticleTypeResource::class;

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
        }

        return $result;
    }
}
