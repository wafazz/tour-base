<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use App\Models\TourJob;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MonthlyOverviewChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Overview';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '280px';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect();
        $jobData = collect();
        $appData = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));

            $jobData->push(
                TourJob::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );

            $appData->push(
                Application::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jobs Posted',
                    'data' => $jobData->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
                [
                    'label' => 'Applications',
                    'data' => $appData->toArray(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
