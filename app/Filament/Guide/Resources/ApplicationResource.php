<?php

namespace App\Filament\Guide\Resources;

use App\Filament\Guide\Resources\ApplicationResource\Pages;
use App\Models\Application;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'My Applications';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Application';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('guide_id', Auth::id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Job Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('tourJob.title')
                            ->label('Job Title'),
                        Infolists\Components\TextEntry::make('tourJob.agency.name')
                            ->label('Agency'),
                        Infolists\Components\TextEntry::make('tourJob.type')
                            ->label('Type')
                            ->badge()
                            ->color(fn (string $state) => match ($state) {
                                'inbound' => 'info',
                                'outbound' => 'warning',
                            }),
                        Infolists\Components\TextEntry::make('tourJob.location')
                            ->label('Location'),
                        Infolists\Components\TextEntry::make('tourJob.fee')
                            ->label('Fee')
                            ->money('MYR'),
                        Infolists\Components\TextEntry::make('tourJob.start_date')
                            ->label('Start Date')
                            ->date('d M Y'),
                        Infolists\Components\TextEntry::make('tourJob.end_date')
                            ->label('End Date')
                            ->date('d M Y'),
                    ])->columns(2),

                Infolists\Components\Section::make('Application Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state) => match ($state) {
                                'pending' => 'warning',
                                'shortlisted' => 'info',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                            }),
                        Infolists\Components\TextEntry::make('applied_at')
                            ->label('Applied At')
                            ->dateTime('d M Y H:i'),
                        Infolists\Components\TextEntry::make('cover_letter')
                            ->label('Cover Letter')
                            ->columnSpanFull()
                            ->placeholder('No cover letter provided'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tourJob.title')
                    ->label('Job')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('tourJob.agency.name')
                    ->label('Agency')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('tourJob.type')
                    ->label('Type')
                    ->colors([
                        'info' => 'inbound',
                        'warning' => 'outbound',
                    ]),
                Tables\Columns\TextColumn::make('tourJob.fee')
                    ->label('Fee')
                    ->money('MYR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tourJob.start_date')
                    ->label('Start')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'shortlisted',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('applied_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('applied_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'shortlisted' => 'Shortlisted',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApplications::route('/'),
            'view' => Pages\ViewApplication::route('/{record}'),
        ];
    }
}
