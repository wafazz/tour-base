<?php

namespace App\Filament\Guide\Widgets;

use App\Models\Application;
use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class GuideStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $guideId = Auth::id();

        $totalApps = Application::where('guide_id', $guideId)->count();
        $pendingApps = Application::where('guide_id', $guideId)->where('status', 'pending')->count();
        $shortlistedApps = Application::where('guide_id', $guideId)->where('status', 'shortlisted')->count();
        $acceptedApps = Application::where('guide_id', $guideId)->where('status', 'accepted')->count();
        $rejectedApps = Application::where('guide_id', $guideId)->where('status', 'rejected')->count();

        $reviewCount = Review::where('guide_id', $guideId)->count();
        $avgRating = Review::where('guide_id', $guideId)->avg('rating') ?? 0;

        // 7-day trends
        $appTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $appTrend[] = Application::where('guide_id', $guideId)->whereDate('created_at', $date)->count();
        }

        return [
            Stat::make('Applied Jobs', $totalApps)
                ->description('Total applications submitted')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->chart($appTrend),

            Stat::make('Accepted', $acceptedApps)
                ->description('Jobs confirmed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Pending', $pendingApps)
                ->description("{$shortlistedApps} shortlisted")
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Rejected', $rejectedApps)
                ->description('Applications declined')
                ->descriptionIcon('heroicon-m-x-circle')
                ->icon('heroicon-o-x-circle')
                ->color($rejectedApps > 0 ? 'danger' : 'gray'),

            Stat::make('My Rating', number_format($avgRating, 1) . ' / 5.0')
                ->description("{$reviewCount} reviews received")
                ->descriptionIcon('heroicon-m-star')
                ->icon('heroicon-o-star')
                ->color('warning'),

            Stat::make('Success Rate', $totalApps > 0 ? round(($acceptedApps / $totalApps) * 100, 1) . '%' : '0%')
                ->description("{$acceptedApps} of {$totalApps} applications")
                ->descriptionIcon('heroicon-m-chart-bar')
                ->icon('heroicon-o-chart-bar')
                ->color('success'),
        ];
    }
}
