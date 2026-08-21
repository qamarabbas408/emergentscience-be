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
                            ->unique(ArticleType::class, 'slug', ignoreRecord: true)
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
                Forms\Components\Section::make('File Requirements')
                    ->description('Configure which file types are allowed for this article type.')
                    ->schema([
                        Forms\Components\Section::make('Manuscript')
                            ->icon('heroicon-o-document-text')
                            ->columns(3)
                            ->schema([
                                Forms\Components\Toggle::make('manuscript_enabled')
                                    ->label('Enabled')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['manuscript']['enabled'] ?? false);
                                        }
                                    }),
                                Forms\Components\TextInput::make('manuscript_max_size_mb')
                                    ->label('Max Size (MB)')
                                    ->numeric()
                                    ->default(50)
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['manuscript']['max_size_mb'] ?? 50);
                                        }
                                    }),
                                Forms\Components\TagsInput::make('manuscript_extensions')
                                    ->label('Allowed Extensions')
                                    ->placeholder('.pdf, .docx')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['manuscript']['extensions'] ?? []);
                                        }
                                    }),
                            ]),
                        Forms\Components\Section::make('Figures')
                            ->icon('heroicon-o-photo')
                            ->columns(3)
                            ->schema([
                                Forms\Components\Toggle::make('figures_enabled')
                                    ->label('Enabled')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['figures']['enabled'] ?? false);
                                        }
                                    }),
                                Forms\Components\TextInput::make('figures_max_size_mb')
                                    ->label('Max Size (MB)')
                                    ->numeric()
                                    ->default(20)
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['figures']['max_size_mb'] ?? 20);
                                        }
                                    }),
                                Forms\Components\TagsInput::make('figures_extensions')
                                    ->label('Allowed Extensions')
                                    ->placeholder('.jpg, .png')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['figures']['extensions'] ?? []);
                                        }
                                    }),
                            ]),
                        Forms\Components\Section::make('Supplementary')
                            ->icon('heroicon-o-paper-clip')
                            ->columns(3)
                            ->schema([
                                Forms\Components\Toggle::make('supplementary_enabled')
                                    ->label('Enabled')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['supplementary']['enabled'] ?? false);
                                        }
                                    }),
                                Forms\Components\TextInput::make('supplementary_max_size_mb')
                                    ->label('Max Size (MB)')
                                    ->numeric()
                                    ->default(200)
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['supplementary']['max_size_mb'] ?? 200);
                                        }
                                    }),
                                Forms\Components\TagsInput::make('supplementary_extensions')
                                    ->label('Allowed Extensions')
                                    ->placeholder('.pdf, .xlsx')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['supplementary']['extensions'] ?? []);
                                        }
                                    }),
                            ]),
                        Forms\Components\Section::make('Reviewer Materials')
                            ->icon('heroicon-o-lock-closed')
                            ->columns(3)
                            ->schema([
                                Forms\Components\Toggle::make('reviewer_materials_enabled')
                                    ->label('Enabled')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['reviewer_materials']['enabled'] ?? false);
                                        }
                                    }),
                                Forms\Components\TextInput::make('reviewer_materials_max_size_mb')
                                    ->label('Max Size (MB)')
                                    ->numeric()
                                    ->default(50)
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['reviewer_materials']['max_size_mb'] ?? 50);
                                        }
                                    }),
                                Forms\Components\TagsInput::make('reviewer_materials_extensions')
                                    ->label('Allowed Extensions')
                                    ->placeholder('.pdf, .doc, .docx')
                                    ->afterStateHydrated(function ($component, $operation, $record) {
                                        if ($record) {
                                            $fr = $record->file_requirements;
                                            $component->state($fr['reviewer_materials']['extensions'] ?? []);
                                        }
                                    }),
                            ]),
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
