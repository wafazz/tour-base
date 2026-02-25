<?php

namespace App\Filament\Agency\Widgets;

use App\Models\Application;
use App\Models\TourJob;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AgencyMonthlyChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Overview';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '280px';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $agencyId = Auth::id();
        $jobIds = TourJob::where('agency_id', $agencyId)->pluck('id');

        $months = collect();
        $jobData = collect();
        $appData = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));

            $jobData->push(
                TourJob::where('agency_id', $agencyId)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );

            $appData->push(
                Application::whereIn('tour_job_id', $jobIds)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jobs Posted',
                    'data' => $jobData->toArray(),
                    'backgroundColor' => 'rgba(27, 42, 74, 0.2)',
                    'borderColor' => 'rgb(27, 42, 74)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
                [
                    'label' => 'Applications Received',
                    'data' => $appData->toArray(),
                    'backgroundColor' => 'rgba(212, 168, 67, 0.2)',
                    'borderColor' => 'rgb(212, 168, 67)',
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
