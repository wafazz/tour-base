<?php

namespace App\Filament\Admin\Widgets;

use App\Models\TourJob;
use Filament\Widgets\ChartWidget;

class JobTypeChart extends ChartWidget
{
    protected static ?string $heading = 'Jobs by Type';

    protected static ?int $sort = 4;

    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $inbound = TourJob::where('type', 'inbound')->count();
        $outbound = TourJob::where('type', 'outbound')->count();

        return [
            'datasets' => [
                [
                    'data' => [$inbound, $outbound],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                    ],
                    'borderColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(245, 158, 11)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Inbound', 'Outbound'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
