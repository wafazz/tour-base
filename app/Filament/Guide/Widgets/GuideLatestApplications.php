<?php

namespace App\Filament\Guide\Widgets;

use App\Models\Application;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class GuideLatestApplications extends BaseWidget
{
    protected static ?string $heading = 'My Recent Applications';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Application::query()
                    ->where('guide_id', Auth::id())
                    ->with(['tourJob', 'tourJob.agency'])
                    ->latest('applied_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('tourJob.title')
                    ->label('Job')
                    ->limit(35)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tourJob.agency.name')
                    ->label('Agency'),
                Tables\Columns\TextColumn::make('tourJob.type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'inbound' => 'info',
                        'outbound' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('tourJob.fee')
                    ->label('Fee')
                    ->money('MYR'),
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
