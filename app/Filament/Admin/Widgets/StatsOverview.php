<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Application;
use App\Models\Invoice;
use App\Models\TourJob;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalUsers = User::count();
        $guidesCount = User::where('role', 'guide')->count();
        $agenciesCount = User::where('role', 'agency')->count();
        $pendingUsers = User::where('status', 'pending')->count();

        $activeJobs = TourJob::where('status', 'active')->count();
        $pendingJobs = TourJob::where('status', 'pending')->count();
        $totalJobs = TourJob::count();

        $totalApps = Application::count();
        $pendingApps = Application::where('status', 'pending')->count();
        $acceptedApps = Application::where('status', 'accepted')->count();

        $paidRevenue = Invoice::where('payment_status', 'paid')->sum('total');
        $pendingRevenue = Invoice::where('payment_status', 'pending')->sum('total');
        $unpaidCount = Invoice::where('payment_status', 'pending')->count();

        // Last 7 days trend data
        $userTrend = [];
        $jobTrend = [];
        $appTrend = [];
        $revTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $userTrend[] = User::whereDate('created_at', $date)->count();
            $jobTrend[] = TourJob::whereDate('created_at', $date)->count();
            $appTrend[] = Application::whereDate('created_at', $date)->count();
            $revTrend[] = (int) Invoice::where('payment_status', 'paid')->whereDate('paid_at', $date)->sum('total');
        }

        return [
            Stat::make('Total Users', $totalUsers)
                ->description("{$guidesCount} guides, {$agenciesCount} agencies")
                ->descriptionIcon('heroicon-m-user-group')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->chart($userTrend),

            Stat::make('Pending Approval', $pendingUsers)
                ->description('Users awaiting review')
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-shield-exclamation')
                ->color($pendingUsers > 0 ? 'danger' : 'success')
                ->chart($userTrend),

            Stat::make('Active Jobs', $activeJobs)
                ->description("{$pendingJobs} pending, {$totalJobs} total")
                ->descriptionIcon('heroicon-m-briefcase')
                ->icon('heroicon-o-briefcase')
                ->color('success')
                ->chart($jobTrend),

            Stat::make('Applications', $totalApps)
                ->description("{$pendingApps} pending, {$acceptedApps} accepted")
                ->descriptionIcon('heroicon-m-document-text')
                ->icon('heroicon-o-paper-airplane')
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
        ];
    }
}
