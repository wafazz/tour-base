<?php

namespace App\Filament\Guide\Widgets;

use App\Models\Application;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class GuideApplicationChart extends ChartWidget
{
    protected static ?string $heading = 'My Applications (Last 6 Months)';

    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '280px';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $guideId = Auth::id();

        $months = collect();
        $applied = collect();
        $accepted = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));

            $applied->push(
                Application::where('guide_id', $guideId)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );

            $accepted->push(
                Application::where('guide_id', $guideId)
                    ->where('status', 'accepted')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            );
        }

        return [
            'datasets' => [
                [
                    'label' => 'Applied',
                    'data' => $applied->toArray(),
                    'backgroundColor' => 'rgba(27, 42, 74, 0.2)',
                    'borderColor' => 'rgb(27, 42, 74)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
                [
                    'label' => 'Accepted',
                    'data' => $accepted->toArray(),
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
