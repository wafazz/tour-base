<?php

namespace App\Filament\Agency\Widgets;

use App\Models\Application;
use App\Models\TourJob;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class AgencyLatestApplications extends BaseWidget
{
    protected static ?string $heading = 'Recent Applications';

    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $jobIds = TourJob::where('agency_id', Auth::id())->pluck('id');

        return $table
            ->query(
                Application::query()
                    ->whereIn('tour_job_id', $jobIds)
                    ->with(['guide', 'tourJob'])
                    ->latest('applied_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('guide.name')
                    ->label('Guide')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tourJob.title')
                    ->label('Job')
                    ->limit(30),
                Tables\Columns\TextColumn::make('tourJob.type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'inbound' => 'info',
                        'outbound' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'shortlisted' => 'info',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('applied_at')
                    ->label('Applied')
                    ->since()
                    ->sortable(),
            ])
            ->defaultPaginationPageOption(5)
            ->defaultSort('applied_at', 'desc');
    }
}
