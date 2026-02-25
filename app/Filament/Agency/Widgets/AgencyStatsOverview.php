<?php

namespace App\Filament\Agency\Widgets;

use App\Models\Application;
use App\Models\Invoice;
use App\Models\Review;
use App\Models\TourJob;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AgencyStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $agencyId = Auth::id();
        $jobIds = TourJob::where('agency_id', $agencyId)->pluck('id');

        $totalJobs = TourJob::where('agency_id', $agencyId)->count();
        $activeJobs = TourJob::where('agency_id', $agencyId)->where('status', 'active')->count();
        $pendingJobs = TourJob::where('agency_id', $agencyId)->where('status', 'pending')->count();

        $totalApps = Application::whereIn('tour_job_id', $jobIds)->count();
        $pendingApps = Application::whereIn('tour_job_id', $jobIds)->where('status', 'pending')->count();
        $acceptedApps = Application::whereIn('tour_job_id', $jobIds)->where('status', 'accepted')->count();

        $paidRevenue = Invoice::where('agency_id', $agencyId)->where('payment_status', 'paid')->sum('total');
        $pendingRevenue = Invoice::where('agency_id', $agencyId)->where('payment_status', 'pending')->sum('total');
        $unpaidCount = Invoice::where('agency_id', $agencyId)->where('payment_status', 'pending')->count();

        $reviewsGiven = Review::where('agency_id', $agencyId)->count();
        $avgRating = Review::where('agency_id', $agencyId)->avg('rating') ?? 0;

        // 7-day trends
        $jobTrend = [];
        $appTrend = [];
        $revTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $jobTrend[] = TourJob::where('agency_id', $agencyId)->whereDate('created_at', $date)->count();
            $appTrend[] = Application::whereIn('tour_job_id', $jobIds)->whereDate('created_at', $date)->count();
            $revTrend[] = (int) Invoice::where('agency_id', $agencyId)->where('payment_status', 'paid')->whereDate('paid_at', $date)->sum('total');
        }

        return [
            Stat::make('My Jobs', $totalJobs)
                ->description("{$activeJobs} active, {$pendingJobs} pending")
                ->descriptionIcon('heroicon-m-briefcase')
                ->icon('heroicon-o-briefcase')
                ->color('primary')
                ->chart($jobTrend),

            Stat::make('Total Applicants', $totalApps)
                ->description("{$pendingApps} pending, {$acceptedApps} accepted")
                ->descriptionIcon('heroicon-m-user-group')
                ->icon('heroicon-o-user-group')
                ->color('info')
                ->chart($appTrend),

            Stat::make('Revenue (Paid)', 'RM ' . number_format($paidRevenue, 2))
                ->description('RM ' . number_format($pendingRevenue, 2) . ' pending')
                ->descriptionIcon('heroicon-m-banknotes')
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->chart($revTrend),

            Stat::make('Unpaid Invoices', $unpaidCount)
                ->description('RM ' . number_format($pendingRevenue, 2) . ' outstanding')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->icon('heroicon-o-document-currency-dollar')
                ->color($unpaidCount > 0 ? 'warning' : 'success')
                ->chart($revTrend),

            Stat::make('Reviews Given', $reviewsGiven)
                ->description('Avg: ' . number_format($avgRating, 1) . ' / 5.0')
                ->descriptionIcon('heroicon-m-star')
                ->icon('heroicon-o-star')
                ->color('warning'),

            Stat::make('Acceptance Rate', $totalApps > 0 ? round(($acceptedApps / $totalApps) * 100, 1) . '%' : '0%')
                ->description("{$acceptedApps} of {$totalApps} applications")
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-chart-bar')
                ->color('success'),
        ];
    }
}
