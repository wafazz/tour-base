<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestApplications extends BaseWidget
{
    protected static ?string $heading = 'Recent Applications';

    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Application::query()
                    ->with(['guide', 'tourJob', 'tourJob.agency'])
                    ->latest('applied_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('guide.name')
                    ->label('Guide')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tourJob.title')
                    ->label('Job')
                    ->limit(30),
                Tables\Columns\TextColumn::make('tourJob.agency.name')
                    ->label('Agency'),
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
