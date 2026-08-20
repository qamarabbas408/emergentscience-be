<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleTypeResource\Pages;
use App\Models\ArticleType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleTypeResource extends Resource
{
    protected static ?string $model = ArticleType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identity')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ArticleType::class, 'slug', fn ($record) => $record?->id)
                            ->maxLength(255)
                            ->helperText('e.g. ORIGINAL_RESEARCH'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ]),
                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->rows(4),
                    ]),
                Forms\Components\Section::make('Manuscript Limits')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('max_word_count')
                            ->numeric()
                            ->helperText('Max total word count'),
                        Forms\Components\TextInput::make('max_summary_words')
                            ->numeric()
                            ->helperText('Max abstract word count'),
                        Forms\Components\TextInput::make('max_figures_tables')
                            ->numeric()
                            ->helperText('Max figures + tables'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('max_word_count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_summary_words')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_figures_tables')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticleTypes::route('/'),
            'create' => Pages\CreateArticleType::route('/create'),
            'edit' => Pages\EditArticleType::route('/{record}/edit'),
        ];
    }
}
