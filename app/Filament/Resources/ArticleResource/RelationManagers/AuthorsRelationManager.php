<?php

namespace App\Filament\Resources\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AuthorsRelationManager extends RelationManager
{
    protected static string $relationship = 'authors';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('orcid')
                    ->maxLength(255)
                    ->helperText('e.g. 0000-0002-1825-0097'),
                Forms\Components\TextInput::make('affiliation')
                    ->maxLength(255)
                    ->helperText('Institution or organization'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->helperText('Author sequence (1 = first author)'),
                Forms\Components\Toggle::make('is_corresponding')
                    ->default(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orcid')
                    ->label('ORCID'),
                Tables\Columns\TextColumn::make('affiliation')
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_corresponding')
                    ->label('Corresponding')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
