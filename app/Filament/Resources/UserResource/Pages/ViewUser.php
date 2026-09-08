<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Tabs::make('UserTabs')->tabs([
                Infolists\Components\Tabs\Tab::make('Core Profile')
                    ->schema([
                        Infolists\Components\Section::make('Personal Details')
                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('title'),
                                Infolists\Components\TextEntry::make('first_name'),
                                Infolists\Components\TextEntry::make('middle_name'),
                                Infolists\Components\TextEntry::make('last_name'),
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Display Name'),
                                Infolists\Components\TextEntry::make('email'),
                                Infolists\Components\TextEntry::make('primary_affiliation')
                                    ->label('Primary Affiliation')
                                    ->columnSpanFull(),
                                Infolists\Components\TextEntry::make('orcid_id')
                                    ->label('ORCID ID'),
                                Infolists\Components\TextEntry::make('biography')
                                    ->columnSpanFull(),
                            ]),
                        Infolists\Components\Section::make('Address')
                            ->columns(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('country'),
                                Infolists\Components\TextEntry::make('city'),
                                Infolists\Components\TextEntry::make('postal_code'),
                            ]),
                        Infolists\Components\Section::make('Account')
                            ->columns(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('status')
                                    ->badge()
                                    ->color(fn ($state): string => match ((string) (is_object($state) ? $state->value : $state)) {
                                        'active' => 'success',
                                        'pending' => 'warning',
                                        'inactive' => 'danger',
                                        default => 'gray',
                                    }),
                                Infolists\Components\TextEntry::make('roles')
                                    ->badge()
                                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state)
                                    ->separator(','),
                                Infolists\Components\TextEntry::make('email_verified_at')
                                    ->dateTime(),
                            ]),
                    ]),
                Infolists\Components\Tabs\Tab::make('Author Profile')
                    ->icon('heroicon-o-pencil')
                    ->schema([
                        Infolists\Components\Section::make('Author Details')
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('authorProfile.corresponding_email')
                                    ->label('Corresponding Email'),
                                Infolists\Components\TextEntry::make('authorProfile.department'),
                                Infolists\Components\TextEntry::make('authorProfile.research_interests')
                                    ->label('Research Interests')
                                    ->listWithLineBreaks()
                                    ->columnSpanFull(),
                                Infolists\Components\TextEntry::make('authorProfile.funding_sources')
                                    ->label('Funding Sources')
                                    ->listWithLineBreaks()
                                    ->formatStateUsing(fn ($state) => is_object($state) ? ($state->name ?? json_encode($state)) : (is_array($state) ? ($state['name'] ?? json_encode($state)) : (string) $state))
                                    ->columnSpanFull(),
                            ]),
                    ]),
                Infolists\Components\Tabs\Tab::make('Reviewer Profile')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Infolists\Components\Section::make('Reviewer Details')
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('reviewerProfile.reviewer_status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'approved' => 'success',
                                        'pending' => 'warning',
                                        'rejected' => 'danger',
                                    }),
                                Infolists\Components\TextEntry::make('reviewerProfile.review_availability_status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Available' => 'success',
                                        'On Leave' => 'warning',
                                        'Max Capacity' => 'danger',
                                    }),
                                Infolists\Components\TextEntry::make('reviewerProfile.expertise_keywords')
                                    ->label('Expertise')
                                    ->listWithLineBreaks()
                                    ->columnSpanFull(),
                                Infolists\Components\TextEntry::make('reviewerProfile.max_concurrent_reviews')
                                    ->label('Max Reviews'),
                                Infolists\Components\TextEntry::make('reviewerProfile.total_reviews_completed')
                                    ->label('Completed'),
                                Infolists\Components\TextEntry::make('reviewerProfile.average_review_time_days')
                                    ->label('Avg Time (days)')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) : '—'),
                                Infolists\Components\TextEntry::make('reviewerProfile.rating_score')
                                    ->label('Rating')
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) : '—'),
                            ]),
                    ]),
                Infolists\Components\Tabs\Tab::make('Editor Profile')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Infolists\Components\Section::make('Editor Details')
                            ->columns(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('editorProfile.editor_type')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Editor-in-Chief' => 'primary',
                                        'Associate Editor' => 'info',
                                        'Guest Editor' => 'warning',
                                        'Managing Editor' => 'success',
                                    }),
                                Infolists\Components\TextEntry::make('editorProfile.assignedJournal.title')
                                    ->label('Assigned Journal'),
                                Infolists\Components\TextEntry::make('editorProfile.section_id')
                                    ->label('Section'),
                                Infolists\Components\TextEntry::make('editorProfile.decision_permission_level')
                                    ->label('Permission Level')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Accept/Reject Rights' => 'success',
                                        'Desk Reject Only' => 'warning',
                                        'Advisory' => 'gray',
                                    }),
                                Infolists\Components\TextEntry::make('editorProfile.active_manuscript_count')
                                    ->label('Active Manuscripts'),
                            ]),
                    ]),
            ]),
        ]);
    }
}
