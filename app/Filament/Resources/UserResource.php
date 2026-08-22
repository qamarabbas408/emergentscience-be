<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\AuthorProfileRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\EditorProfileRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\ReviewerProfileRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Users & Roles';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('UserTabs')->tabs([
                Forms\Components\Tabs\Tab::make('Core Profile')
                    ->schema([
                        Forms\Components\Section::make('Personal Details')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Title')
                                    ->datalist(['Dr.', 'Prof.', 'Mr.', 'Ms.', 'Mrs.', 'Mx.']),
                                Forms\Components\TextInput::make('first_name')
                                    ->label('First Name'),
                                Forms\Components\TextInput::make('middle_name')
                                    ->label('Middle Name'),
                                Forms\Components\TextInput::make('last_name')
                                    ->label('Last Name'),
                                Forms\Components\TextInput::make('name')
                                    ->label('Display Name')
                                    ->helperText('Fallback if name parts are empty')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(User::class, 'email', ignoreRecord: true),
                                Forms\Components\TextInput::make('primary_affiliation')
                                    ->label('Primary Affiliation')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('orcid_id')
                                    ->label('ORCID ID')
                                    ->placeholder('0000-0000-0000-0000')
                                    ->maxLength(19)
                                    ->unique(User::class, 'orcid_id', ignoreRecord: true),
                                Forms\Components\Textarea::make('biography')
                                    ->columnSpanFull()
                                    ->rows(4),
                            ]),
                        Forms\Components\Section::make('Address')
                            ->columns(4)
                            ->schema([
                                Forms\Components\TextInput::make('country'),
                                Forms\Components\TextInput::make('city'),
                                Forms\Components\TextInput::make('postal_code')
                                    ->label('Postal Code'),
                            ]),
                        Forms\Components\Section::make('Authentication')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context): bool => $context === 'create')
                                    ->label('Password (leave blank to keep unchanged)'),
                                Forms\Components\DateTimePicker::make('email_verified_at'),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                        'pending' => 'Pending Verification',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ]),
                    ]),
                Forms\Components\Tabs\Tab::make('Author Profile')
                    ->icon('heroicon-o-pencil'),
                Forms\Components\Tabs\Tab::make('Reviewer Profile')
                    ->icon('heroicon-o-eye'),
                Forms\Components\Tabs\Tab::make('Editor Profile')
                    ->icon('heroicon-o-briefcase'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Display Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->getStateUsing(fn ($record) => $record->getFullName())
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('primary_affiliation')
                    ->label('Affiliation')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('orcid_id')
                    ->label('ORCID')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_author')
                    ->label('Author')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->isAuthor()),
                Tables\Columns\IconColumn::make('is_reviewer')
                    ->label('Reviewer')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->isReviewer()),
                Tables\Columns\IconColumn::make('is_editor')
                    ->label('Editor')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->isEditor()),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'warning' => 'pending',
                        'danger' => 'inactive',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'pending' => 'Pending Verification',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuthorProfileRelationManager::class,
            ReviewerProfileRelationManager::class,
            EditorProfileRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}