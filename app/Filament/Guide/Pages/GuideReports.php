<?php

namespace App\Filament\Guide\Pages;

use App\Models\Application;
use App\Models\Review;
use App\Models\TourJob;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuideReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?string $title = 'Reports';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.guide.pages.guide-reports';

    public function getViewData(): array
    {
        $guideId = Auth::id();

        // Applications
        $totalApplications = Application::where('guide_id', $guideId)->count();
        $pendingApplications = Application::where('guide_id', $guideId)->where('status', 'pending')->count();
        $shortlistedApplications = Application::where('guide_id', $guideId)->where('status', 'shortlisted')->count();
        $acceptedApplications = Application::where('guide_id', $guideId)->where('status', 'accepted')->count();
        $rejectedApplications = Application::where('guide_id', $guideId)->where('status', 'rejected')->count();
        $acceptanceRate = $totalApplications > 0
            ? round(($acceptedApplications / $totalApplications) * 100, 1) : 0;

        // Monthly applications (last 6 months)
        $monthlyApplications = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $applied = Application::where('guide_id', $guideId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $accepted = Application::where('guide_id', $guideId)
                ->where('status', 'accepted')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $monthlyApplications->push([
                'month' => $date->format('M Y'),
                'applied' => $applied,
                'accepted' => $accepted,
            ]);
        }

        // Job type breakdown (from accepted applications)
        $acceptedJobIds = Application::where('guide_id', $guideId)
            ->where('status', 'accepted')
            ->pluck('tour_job_id');
        $inboundAccepted = TourJob::whereIn('id', $acceptedJobIds)->where('type', 'inbound')->count();
        $outboundAccepted = TourJob::whereIn('id', $acceptedJobIds)->where('type', 'outbound')->count();

        // Top agencies (that accepted this guide)
        $topAgencies = Application::where('applications.guide_id', $guideId)
            ->where('applications.status', 'accepted')
            ->join('tour_jobs', 'applications.tour_job_id', '=', 'tour_jobs.id')
            ->select('tour_jobs.agency_id', DB::raw('COUNT(*) as accepted_count'))
            ->groupBy('tour_jobs.agency_id')
            ->orderByDesc('accepted_count')
            ->limit(5)
            ->with('tourJob.agency')
            ->get();

        // Top locations (from accepted jobs)
        $topLocations = TourJob::whereIn('id', $acceptedJobIds)
            ->select('location', DB::raw('COUNT(*) as job_count'))
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderByDesc('job_count')
            ->limit(5)
            ->get();

        // Reviews
        $totalReviews = Review::where('guide_id', $guideId)->count();
        $avgRating = Review::where('guide_id', $guideId)->avg('rating') ?? 0;
        $ratingDistribution = [];
        for ($r = 5; $r >= 1; $r--) {
            $ratingDistribution[$r] = Review::where('guide_id', $guideId)->where('rating', $r)->count();
        }

        // Earnings estimate (sum of fees from accepted jobs)
        $totalEarnings = TourJob::whereIn('id', $acceptedJobIds)->sum('fee');
        $avgJobFee = $acceptedJobIds->count() > 0 ? TourJob::whereIn('id', $acceptedJobIds)->avg('fee') : 0;

        return compact(
            'totalApplications', 'pendingApplications', 'shortlistedApplications',
            'acceptedApplications', 'rejectedApplications', 'acceptanceRate',
            'monthlyApplications',
            'inboundAccepted', 'outboundAccepted',
            'topAgencies', 'topLocations',
            'totalReviews', 'avgRating', 'ratingDistribution',
            'totalEarnings', 'avgJobFee',
        );
    }
}
