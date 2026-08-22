<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\EditorProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EditorProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'editorProfile';
    protected static ?string $title = 'Editor Profile';
    protected static ?string $icon = 'heroicon-o-briefcase';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Editor Details')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('editor_type')
                        ->options([
                            'Editor-in-Chief' => 'Editor-in-Chief',
                            'Associate Editor' => 'Associate Editor',
                            'Guest Editor' => 'Guest Editor',
                            'Managing Editor' => 'Managing Editor',
                        ])
                        ->required()
                        ->searchable(),
                    Forms\Components\Select::make('assigned_journal_id')
                        ->label('Assigned Journal')
                        ->relationship('assignedJournal', 'title')
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('section_id')
                        ->label('Section ID')
                        ->helperText('Optional: specific section/topic within the journal'),
                    Forms\Components\Select::make('decision_permission_level')
                        ->options([
                            'Accept/Reject Rights' => 'Accept/Reject Rights',
                            'Desk Reject Only' => 'Desk Reject Only',
                            'Advisory' => 'Advisory',
                        ])
                        ->default('Advisory')
                        ->required(),
                    Forms\Components\TextInput::make('active_manuscript_count')
                        ->label('Active Manuscript Count')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('editor_type')
            ->columns([
                Tables\Columns\TextColumn::make('editor_type')
                    ->badge()
                    ->colors([
                        'primary' => 'Editor-in-Chief',
                        'info' => 'Associate Editor',
                        'warning' => 'Guest Editor',
                        'success' => 'Managing Editor',
                    ]),
                Tables\Columns\TextColumn::make('assignedJournal.title')
                    ->label('Journal')
                    ->limit(30),
                Tables\Columns\TextColumn::make('section_id')->label('Section'),
                Tables\Columns\TextColumn::make('decision_permission_level')
                    ->label('Permission Level')
                    ->badge()
                    ->colors([
                        'success' => 'Accept/Reject Rights',
                        'warning' => 'Desk Reject Only',
                        'gray' => 'Advisory',
                    ]),
                Tables\Columns\TextColumn::make('active_manuscript_count')
                    ->label('Active Manuscripts'),
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