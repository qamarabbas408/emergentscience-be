<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalResource\Pages;
use App\Models\Journal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Catalog';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identity')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(Journal::class, 'slug', fn ($record) => $record ? $record->id : null)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('abbreviation')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('doi_prefix')
                            ->required()
                            ->helperText('e.g. 10.3390'),
                    ]),
                Forms\Components\Section::make('Identifiers')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('issn')->maxLength(255),
                        Forms\Components\TextInput::make('eissn')->maxLength(255),
                        Forms\Components\TextInput::make('discipline')
                            ->maxLength(255)
                            ->columnSpan(2),
                    ]),
                Forms\Components\Section::make('Policy')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('license')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Accepting submissions')
                            ->default(true),
                    ]),
                Forms\Components\Section::make('Apc / Fees')
                    ->description('Billing data — permissioned away from editorial views (COPE)')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('apc_amount')
                            ->numeric()
                            ->prefix('$'),
                        Forms\Components\TextInput::make('apc_currency')
                            ->maxLength(3)
                            ->helperText('ISO code, e.g. USD'),
                    ]),
                Forms\Components\Section::make('Scope')
                    ->schema([
                        Forms\Components\Textarea::make('scope')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discipline')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doi_prefix')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('apc_amount')
                    ->money(fn ($record) => $record->apc_currency ?: 'USD', 2)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Accepting submissions'),
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
            // reserved for future RelationManagers (sections, topics, special_issues)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJournals::route('/'),
            'create' => Pages\CreateJournal::route('/create'),
            'view' => Pages\ViewJournal::route('/{record}'),
            'edit' => Pages\EditJournal::route('/{record}/edit'),
        ];
    }
}
