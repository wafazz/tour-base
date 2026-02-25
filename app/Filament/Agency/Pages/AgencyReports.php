<?php

namespace App\Filament\Agency\Pages;

use App\Models\Application;
use App\Models\Invoice;
use App\Models\Review;
use App\Models\TourJob;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgencyReports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?string $title = 'Reports';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.agency.pages.agency-reports';

    public function getViewData(): array
    {
        $agencyId = Auth::id();
        $jobIds = TourJob::where('agency_id', $agencyId)->pluck('id');

        // Jobs
        $totalJobs = TourJob::where('agency_id', $agencyId)->count();
        $activeJobs = TourJob::where('agency_id', $agencyId)->where('status', 'active')->count();
        $pendingJobs = TourJob::where('agency_id', $agencyId)->where('status', 'pending')->count();
        $closedJobs = TourJob::where('agency_id', $agencyId)->where('status', 'closed')->count();
        $inboundJobs = TourJob::where('agency_id', $agencyId)->where('type', 'inbound')->count();
        $outboundJobs = TourJob::where('agency_id', $agencyId)->where('type', 'outbound')->count();
        $avgFee = TourJob::where('agency_id', $agencyId)->avg('fee') ?? 0;

        // Applications
        $totalApplications = Application::whereIn('tour_job_id', $jobIds)->count();
        $pendingApplications = Application::whereIn('tour_job_id', $jobIds)->where('status', 'pending')->count();
        $shortlistedApplications = Application::whereIn('tour_job_id', $jobIds)->where('status', 'shortlisted')->count();
        $acceptedApplications = Application::whereIn('tour_job_id', $jobIds)->where('status', 'accepted')->count();
        $rejectedApplications = Application::whereIn('tour_job_id', $jobIds)->where('status', 'rejected')->count();
        $acceptanceRate = $totalApplications > 0
            ? round(($acceptedApplications / $totalApplications) * 100, 1) : 0;

        // Revenue
        $totalRevenue = Invoice::where('agency_id', $agencyId)->where('payment_status', 'paid')->sum('total');
        $pendingRevenue = Invoice::where('agency_id', $agencyId)->where('payment_status', 'pending')->sum('total');
        $totalInvoices = Invoice::where('agency_id', $agencyId)->count();
        $paidInvoices = Invoice::where('agency_id', $agencyId)->where('payment_status', 'paid')->count();
        $pendingInvoiceCount = Invoice::where('agency_id', $agencyId)->where('payment_status', 'pending')->count();
        $collectionRate = $totalInvoices > 0
            ? round(($paidInvoices / $totalInvoices) * 100, 1) : 0;

        // Monthly revenue (last 6 months)
        $monthlyRevenue = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $paid = Invoice::where('agency_id', $agencyId)->where('payment_status', 'paid')
                ->whereYear('issued_at', $date->year)
                ->whereMonth('issued_at', $date->month)
                ->sum('total');
            $pending = Invoice::where('agency_id', $agencyId)->where('payment_status', 'pending')
                ->whereYear('issued_at', $date->year)
                ->whereMonth('issued_at', $date->month)
                ->sum('total');
            $monthlyRevenue->push([
                'month' => $date->format('M Y'),
                'paid' => (float) $paid,
                'pending' => (float) $pending,
                'total' => (float) $paid + (float) $pending,
            ]);
        }

        // Monthly jobs posted (last 6 months)
        $monthlyJobs = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = TourJob::where('agency_id', $agencyId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $apps = Application::whereIn('tour_job_id', $jobIds)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $monthlyJobs->push([
                'month' => $date->format('M Y'),
                'jobs' => $count,
                'apps' => $apps,
            ]);
        }

        // Top locations
        $topLocations = TourJob::where('agency_id', $agencyId)
            ->select('location', DB::raw('COUNT(*) as job_count'))
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderByDesc('job_count')
            ->limit(5)
            ->get();

        // Top guides (by accepted applications for this agency)
        $topGuides = Application::whereIn('tour_job_id', $jobIds)
            ->where('status', 'accepted')
            ->select('guide_id', DB::raw('COUNT(*) as accepted_count'))
            ->groupBy('guide_id')
            ->orderByDesc('accepted_count')
            ->limit(5)
            ->with('guide')
            ->get();

        // Reviews
        $totalReviews = Review::where('agency_id', $agencyId)->count();
        $avgRating = Review::where('agency_id', $agencyId)->avg('rating') ?? 0;

        return compact(
            'totalJobs', 'activeJobs', 'pendingJobs', 'closedJobs',
            'inboundJobs', 'outboundJobs', 'avgFee',
            'totalApplications', 'pendingApplications', 'shortlistedApplications',
            'acceptedApplications', 'rejectedApplications', 'acceptanceRate',
            'totalRevenue', 'pendingRevenue', 'totalInvoices', 'paidInvoices',
            'pendingInvoiceCount', 'collectionRate',
            'monthlyRevenue', 'monthlyJobs',
            'topLocations', 'topGuides',
            'totalReviews', 'avgRating',
        );
    }
}
