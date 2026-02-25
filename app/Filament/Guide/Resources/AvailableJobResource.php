<?php

namespace App\Filament\Guide\Resources;

use App\Filament\Guide\Resources\AvailableJobResource\Pages;
use App\Models\Application;
use App\Models\TourJob;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AvailableJobResource extends Resource
{
    protected static ?string $model = TourJob::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Browse Jobs';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Available Job';

    protected static ?string $pluralModelLabel = 'Available Jobs';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'active')
            ->whereNotNull('admin_approved_at');
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
                        Infolists\Components\TextEntry::make('title')
                            ->label('Job Title')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        Infolists\Components\TextEntry::make('agency.name')
                            ->label('Agency'),
                        Infolists\Components\TextEntry::make('type')
                            ->badge()
                            ->color(fn (string $state) => match ($state) {
                                'inbound' => 'info',
                                'outbound' => 'warning',
                            }),
                        Infolists\Components\TextEntry::make('location'),
                        Infolists\Components\TextEntry::make('fee')
                            ->money('MYR'),
                        Infolists\Components\TextEntry::make('start_date')
                            ->date('d M Y'),
                        Infolists\Components\TextEntry::make('end_date')
                            ->date('d M Y'),
                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('requirements')
                            ->columnSpanFull()
                            ->placeholder('No specific requirements listed'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('agency.name')
                    ->label('Agency')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'info' => 'inbound',
                        'warning' => 'outbound',
                    ]),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fee')
                    ->money('MYR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'inbound' => 'Inbound',
                        'outbound' => 'Outbound',
                    ]),
                Tables\Filters\Filter::make('location')
                    ->form([
                        Forms\Components\TextInput::make('location')
                            ->placeholder('Search location...'),
                    ])
                    ->query(fn (Builder $query, array $data) => $query->when(
                        $data['location'],
                        fn (Builder $q, $value) => $q->where('location', 'like', "%{$value}%")
                    )),
                Tables\Filters\Filter::make('date_range')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Start from'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Start until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn (Builder $q, $date) => $q->whereDate('start_date', '>=', $date))
                            ->when($data['until'], fn (Builder $q, $date) => $q->whereDate('start_date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('apply')
                    ->label('Apply')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Apply for this job?')
                    ->modalDescription(fn (TourJob $record) => "You are about to apply for: {$record->title}")
                    ->form([
                        Forms\Components\Textarea::make('cover_letter')
                            ->label('Cover Letter (optional)')
                            ->rows(4)
                            ->placeholder('Tell the agency why you are a good fit...'),
                    ])
                    ->hidden(fn (TourJob $record) => Application::where('tour_job_id', $record->id)
                        ->where('guide_id', Auth::id())
                        ->exists())
                    ->action(function (TourJob $record, array $data) {
                        $application = Application::create([
                            'tour_job_id' => $record->id,
                            'guide_id' => Auth::id(),
                            'status' => 'pending',
                            'cover_letter' => $data['cover_letter'] ?? null,
                            'applied_at' => now(),
                        ]);

                        $record->agency->notify(new \App\Notifications\NewApplication($application));

                        Notification::make()
                            ->title('Application submitted!')
                            ->body("You applied for: {$record->title}")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('applied')
                    ->label('Applied')
                    ->icon('heroicon-o-check')
                    ->color('gray')
                    ->disabled()
                    ->visible(fn (TourJob $record) => Application::where('tour_job_id', $record->id)
                        ->where('guide_id', Auth::id())
                        ->exists()),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAvailableJobs::route('/'),
            'view' => Pages\ViewAvailableJob::route('/{record}'),
        ];
    }
}
