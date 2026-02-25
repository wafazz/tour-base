<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use Filament\Widgets\ChartWidget;

class ApplicationStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Applications by Status';

    protected static ?int $sort = 5;

    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $pending = Application::where('status', 'pending')->count();
        $shortlisted = Application::where('status', 'shortlisted')->count();
        $accepted = Application::where('status', 'accepted')->count();
        $rejected = Application::where('status', 'rejected')->count();

        return [
            'datasets' => [
                [
                    'data' => [$pending, $shortlisted, $accepted, $rejected],
                    'backgroundColor' => [
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                    ],
                    'borderColor' => [
                        'rgb(245, 158, 11)',
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(239, 68, 68)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Pending', 'Shortlisted', 'Accepted', 'Rejected'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
