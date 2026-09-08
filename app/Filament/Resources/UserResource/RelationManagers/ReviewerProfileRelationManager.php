<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\ReviewerProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewerProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'reviewerProfile';
    protected static ?string $title = 'Reviewer Profile';
    protected static ?string $icon = 'heroicon-o-eye';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Reviewer Details')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('expertise_keywords')
                        ->label('Expertise Keywords (comma-separated)')
                        ->helperText('e.g. Deep Learning, Medical Imaging, Biostatistics'),
                Forms\Components\Select::make('review_availability_status')
                    ->options([
                        'Available' => 'Available',
                        'On Leave' => 'On Leave',
                        'Max Capacity' => 'Max Capacity',
                    ])
                    ->default('Available')
                    ->required(),
                Forms\Components\Select::make('reviewer_status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),
                    Forms\Components\TextInput::make('max_concurrent_reviews')
                        ->label('Max Concurrent Reviews')
                        ->numeric()
                        ->default(5)
                        ->minValue(1)
                        ->required(),
                    Forms\Components\TextInput::make('total_reviews_completed')
                        ->label('Total Reviews Completed')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    Forms\Components\TextInput::make('average_review_time_days')
                        ->label('Average Review Time (days)')
                        ->numeric()
                        ->step(0.1)
                        ->minValue(0),
                    Forms\Components\TextInput::make('rating_score')
                        ->label('Internal Rating Score')
                        ->numeric()
                        ->step(0.01)
                        ->minValue(0)
                        ->maxValue(5),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('review_availability_status')
                    ->columns([
                        Tables\Columns\TextColumn::make('reviewer_status')
                            ->badge()
                            ->colors([
                                'warning' => 'pending',
                                'success' => 'approved',
                                'danger' => 'rejected',
                            ]),
                        Tables\Columns\TextColumn::make('review_availability_status')
                    ->badge()
                    ->colors([
                        'success' => 'Available',
                        'warning' => 'On Leave',
                        'danger' => 'Max Capacity',
                    ]),
                Tables\Columns\TextColumn::make('max_concurrent_reviews')->label('Max Reviews'),
                Tables\Columns\TextColumn::make('total_reviews_completed')->label('Completed'),
                Tables\Columns\TextColumn::make('average_review_time_days')
                    ->label('Avg Time (days)')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) : '—'),
                Tables\Columns\TextColumn::make('rating_score')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) : '—'),
                Tables\Columns\TextColumn::make('expertise_keywords')
                    ->label('Expertise')
                    ->limit(50)
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Reviewer')
                    ->modalDescription('This will grant the user reviewer access.')
                    ->visible(fn ($record) => $record->reviewer_status === 'pending')
                    ->action(function ($record) {
                        $record->update(['reviewer_status' => 'approved']);
                        $record->user->addRole('reviewer');
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Reviewer')
                    ->modalDescription('This will reject the reviewer request.')
                    ->visible(fn ($record) => $record->reviewer_status === 'pending')
                    ->action(fn ($record) => $record->update(['reviewer_status' => 'rejected'])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}