<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\AuthorProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AuthorProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'authorProfile';
    protected static ?string $title = 'Author Profile';
    protected static ?string $icon = 'heroicon-o-pencil';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Author Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('corresponding_email')
                        ->email()
                        ->label('Corresponding Email'),
                    Forms\Components\TextInput::make('department'),
                    Forms\Components\TextInput::make('research_interests')
                        ->label('Research Interests (comma-separated)')
                        ->helperText('e.g. Machine Learning, Computer Vision, NLP'),
                    Forms\Components\TextInput::make('funding_sources')
                        ->label('Funding Sources (comma-separated)')
                        ->helperText('e.g. NSF Grant #12345, ERC Advanced Grant'),
                    Forms\Components\TextInput::make('co_author_history')
                        ->label('Co-author History (comma-separated)')
                        ->helperText('Previous co-author names or IDs'),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('corresponding_email')
            ->columns([
                Tables\Columns\TextColumn::make('corresponding_email')->label('Corresponding Email'),
                Tables\Columns\TextColumn::make('department'),
                Tables\Columns\TextColumn::make('research_interests')
                    ->label('Research Interests')
                    ->limit(50)
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
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