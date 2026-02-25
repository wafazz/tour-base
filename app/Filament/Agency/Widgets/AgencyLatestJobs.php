<?php

namespace App\Filament\Agency\Widgets;

use App\Models\TourJob;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class AgencyLatestJobs extends BaseWidget
{
    protected static ?string $heading = 'My Latest Jobs';

    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TourJob::query()
                    ->where('agency_id', Auth::id())
                    ->withCount('applications')
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(35),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'inbound' => 'info',
                        'outbound' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('location'),
                Tables\Columns\TextColumn::make('fee')
                    ->money('MYR'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d M Y'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'active' => 'success',
                        'closed' => 'gray',
                    }),
                Tables\Columns\TextColumn::make('applications_count')
                    ->label('Apps')
                    ->alignCenter(),
            ])
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc');
    }
}
