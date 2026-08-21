<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ArticleGuide extends Page
{
    protected static string $view = 'filament.pages.article-guide';

    protected static ?string $navigationGroup = 'Help';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Article Guide';
    protected static ?int $navigationSort = 101;

    public static function getNavigationUrl(): string
    {
        return static::getUrl();
    }
}
