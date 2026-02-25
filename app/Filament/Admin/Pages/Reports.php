<?php

namespace App\Filament\Admin\Pages;

use App\Models\Application;
use App\Models\Invoice;
use App\Models\Review;
use App\Models\TourJob;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Analytics';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.admin.pages.reports';

    public function getViewData(): array
    {
        // Users
        $totalUsers = User::count();
        $totalGuides = User::where('role', 'guide')->count();
        $totalAgencies = User::where('role', 'agency')->count();
        $pendingUsers = User::where('status', 'pending')->count();
        $approvedUsers = User::where('status', 'approved')->count();
        $rejectedUsers = User::where('status', 'rejected')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->count();

        // Jobs
        $totalJobs = TourJob::count();
        $activeJobs = TourJob::where('status', 'active')->count();
        $pendingJobs = TourJob::where('status', 'pending')->count();
        $closedJobs = TourJob::where('status', 'closed')->count();
        $inboundJobs = TourJob::where('type', 'inbound')->count();
        $outboundJobs = TourJob::where('type', 'outbound')->count();
        $avgFee = TourJob::avg('fee') ?? 0;

        // Applications
        $totalApplications = Application::count();
        $pendingApplications = Application::where('status', 'pending')->count();
        $shortlistedApplications = Application::where('status', 'shortlisted')->count();
        $acceptedApplications = Application::where('status', 'accepted')->count();
        $rejectedApplications = Application::where('status', 'rejected')->count();
        $acceptanceRate = $totalApplications > 0
            ? round(($acceptedApplications / $totalApplications) * 100, 1) : 0;

        // Revenue
        $totalRevenue = Invoice::where('payment_status', 'paid')->sum('total');
        $pendingRevenue = Invoice::where('payment_status', 'pending')->sum('total');
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('payment_status', 'paid')->count();
        $pendingInvoiceCount = Invoice::where('payment_status', 'pending')->count();
        $collectionRate = $totalInvoices > 0
            ? round(($paidInvoices / $totalInvoices) * 100, 1) : 0;

        // Monthly revenue (last 6 months)
        $monthlyRevenue = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $paid = Invoice::where('payment_status', 'paid')
                ->whereYear('issued_at', $date->year)
                ->whereMonth('issued_at', $date->month)
                ->sum('total');
            $pending = Invoice::where('payment_status', 'pending')
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

        // Monthly registrations (last 6 months)
        $monthlyRegistrations = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $guides = User::where('role', 'guide')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $agencies = User::where('role', 'agency')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
            $monthlyRegistrations->push([
                'month' => $date->format('M Y'),
                'guides' => $guides,
                'agencies' => $agencies,
                'total' => $guides + $agencies,
            ]);
        }

        // Top agencies by job count
        $topAgencies = User::where('role', 'agency')
            ->withCount('tourJobs')
            ->orderByDesc('tour_jobs_count')
            ->limit(5)
            ->get();

        // Top guides by accepted applications
        $topGuides = User::where('role', 'guide')
            ->withCount(['applications as accepted_count' => function ($q) {
                $q->where('status', 'accepted');
            }])
            ->withCount('applications as total_apps')
            ->withAvg('reviewsReceived', 'rating')
            ->orderByDesc('accepted_count')
            ->limit(5)
            ->get();

        // Top locations
        $topLocations = TourJob::select('location', DB::raw('COUNT(*) as job_count'))
            ->whereNotNull('location')
            ->groupBy('location')
            ->orderByDesc('job_count')
            ->limit(5)
            ->get();

        // Reviews
        $totalReviews = Review::count();
        $avgRating = Review::avg('rating') ?? 0;

        return compact(
            'totalUsers', 'totalGuides', 'totalAgencies', 'pendingUsers',
            'approvedUsers', 'rejectedUsers', 'newUsersThisMonth',
            'totalJobs', 'activeJobs', 'pendingJobs', 'closedJobs',
            'inboundJobs', 'outboundJobs', 'avgFee',
            'totalApplications', 'pendingApplications', 'shortlistedApplications',
            'acceptedApplications', 'rejectedApplications', 'acceptanceRate',
            'totalRevenue', 'pendingRevenue', 'totalInvoices', 'paidInvoices',
            'pendingInvoiceCount', 'collectionRate',
            'monthlyRevenue', 'monthlyRegistrations',
            'topAgencies', 'topGuides', 'topLocations',
            'totalReviews', 'avgRating',
        );
    }
}
