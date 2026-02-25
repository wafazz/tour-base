<?php

namespace App\Filament\Agency\Widgets;

use App\Models\Invoice;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AgencyRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue (Last 6 Months)';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $agencyId = Auth::id();

        $months = collect();
        $paid = collect();
        $pending = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));

            $paid->push(
                (float) Invoice::where('agency_id', $agencyId)
                    ->where('payment_status', 'paid')
                    ->whereYear('issued_at', $date->year)
                    ->whereMonth('issued_at', $date->month)
                    ->sum('total')
            );

            $pending->push(
                (float) Invoice::where('agency_id', $agencyId)
                    ->where('payment_status', 'pending')
                    ->whereYear('issued_at', $date->year)
                    ->whereMonth('issued_at', $date->month)
                    ->sum('total')
            );
        }

        return [
            'datasets' => [
                [
                    'label' => 'Paid (RM)',
                    'data' => $paid->toArray(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.7)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'Pending (RM)',
                    'data' => $pending->toArray(),
                    'backgroundColor' => 'rgba(245, 158, 11, 0.7)',
                    'borderColor' => 'rgb(245, 158, 11)',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
