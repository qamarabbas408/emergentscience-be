<?php

namespace App\Filament\Resources\ArticleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('file_type')
                    ->options([
                        'manuscript' => 'Manuscript',
                        'figures' => 'Figures',
                        'supplementary' => 'Supplementary',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('File')
                    ->directory('articles')
                    ->disk('local')
                    ->required()
                    ->storeFile(false),
                Forms\Components\TextInput::make('file_name')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\TextInput::make('file_size')
                    ->numeric()
                    ->disabled()
                    ->helperText('Bytes'),
                Forms\Components\TextInput::make('mime_type')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_name')
            ->columns([
                Tables\Columns\TextColumn::make('file_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manuscript' => 'info',
                        'figures' => 'success',
                        'supplementary' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('file_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state): string => match (true) {
                        $state >= 1048576 => round($state / 1048576, 1) . ' MB',
                        $state >= 1024 => round($state / 1024, 1) . ' KB',
                        default => $state . ' B',
                    }),
                Tables\Columns\TextColumn::make('mime_type')
                    ->label('MIME'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
