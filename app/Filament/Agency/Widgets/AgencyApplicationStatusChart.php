<?php

namespace App\Filament\Agency\Widgets;

use App\Models\Application;
use App\Models\TourJob;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class AgencyApplicationStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Applications by Status';

    protected static ?int $sort = 4;

    protected static ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $jobIds = TourJob::where('agency_id', Auth::id())->pluck('id');

        $pending = Application::whereIn('tour_job_id', $jobIds)->where('status', 'pending')->count();
        $shortlisted = Application::whereIn('tour_job_id', $jobIds)->where('status', 'shortlisted')->count();
        $accepted = Application::whereIn('tour_job_id', $jobIds)->where('status', 'accepted')->count();
        $rejected = Application::whereIn('tour_job_id', $jobIds)->where('status', 'rejected')->count();

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
