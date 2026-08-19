<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class JournalGuide extends Page
{
    protected static string $view = 'filament.pages.journal-guide';

    protected static ?string $navigationGroup = 'Help';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Journal Guide';
    protected static ?int $navigationSort = 100;

    public static function getNavigationUrl(): string
    {
        return static::getUrl();
    }
}
