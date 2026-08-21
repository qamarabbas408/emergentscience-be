<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers\AuthorsRelationManager;
use App\Filament\Resources\ArticleResource\RelationManagers\FilesRelationManager;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Manuscript')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(Article::class, 'slug', fn ($record) => $record?->id)
                            ->maxLength(255),
                        Forms\Components\Select::make('journal_id')
                            ->relationship('journal', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('article_type_id')
                            ->relationship('articleType', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'submitted' => 'Submitted',
                                'under_review' => 'Under Review',
                                'revision_required' => 'Revision Required',
                                'accepted' => 'Accepted',
                                'published' => 'Published',
                                'rejected' => 'Rejected',
                                'withdrawn' => 'Withdrawn',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('language')
                            ->default('en')
                            ->maxLength(5),
                    ]),
                Forms\Components\Section::make('Abstract & Keywords')
                    ->schema([
                        Forms\Components\Textarea::make('abstract')
                            ->rows(6)
                            ->required(),
                        Forms\Components\TagsInput::make('keywords')
                            ->required(),
                    ]),
                Forms\Components\Section::make('Identifiers')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('doi')
                            ->helperText('e.g. 10.3390/xxxxx'),
                    ]),
                Forms\Components\Section::make('Topics')
                    ->schema([
                        Forms\Components\Select::make('topics')
                            ->relationship('topics', 'title')
                            ->multiple()
                            ->searchable()
                            ->preload(),
                    ]),
                Forms\Components\Section::make('Publication Details')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('volume')
                            ->numeric(),
                        Forms\Components\TextInput::make('issue'),
                        Forms\Components\TextInput::make('page_start'),
                        Forms\Components\TextInput::make('page_end'),
                        Forms\Components\DatePicker::make('publication_date'),
                        Forms\Components\DatePicker::make('date_submitted'),
                        Forms\Components\DatePicker::make('date_accepted'),
                    ]),
                Forms\Components\Section::make('Metrics')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('view_count')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                        Forms\Components\TextInput::make('download_count')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                        Forms\Components\TextInput::make('citation_count')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('journal.title')
                    ->label('Journal')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('articleType.name')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Research Article' => 'info',
                        'Review' => 'success',
                        'Editorial' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'accepted' => 'info',
                        'under_review' => 'warning',
                        'rejected' => 'danger',
                        'draft' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('authors_count')
                    ->counts('authors')
                    ->label('Authors')
                    ->sortable(),
                Tables\Columns\TextColumn::make('publication_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('view_count')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('journal_id')
                    ->relationship('journal', 'title')
                    ->label('Journal'),
                Tables\Filters\SelectFilter::make('article_type_id')
                    ->relationship('articleType', 'name')
                    ->label('Type'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'accepted' => 'Accepted',
                        'published' => 'Published',
                        'rejected' => 'Rejected',
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuthorsRelationManager::class,
            FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
