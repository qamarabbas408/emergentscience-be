<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisciplineCategoryResource\Pages;
use App\Models\DisciplineCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DisciplineCategoryResource extends Resource
{
    protected static ?string $model = DisciplineCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $navigationLabel = 'Discipline Categories';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(DisciplineCategory::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL-safe key, auto-generated from name.'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->helperText('Display order. Lower numbers appear first.'),
                    ]),
                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->helperText('Brief description of this discipline category.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('journals_count')
                    ->counts('journals')
                    ->label('Journals')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
        return [
            // reserved for future RelationManagers (journals)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisciplineCategories::route('/'),
            'create' => Pages\CreateDisciplineCategory::route('/create'),
            'view' => Pages\ViewDisciplineCategory::route('/{record}'),
            'edit' => Pages\EditDisciplineCategory::route('/{record}/edit'),
        ];
    }
}
