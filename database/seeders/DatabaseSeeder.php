<?php

namespace Database\Seeders;

use App\Models\AgencyProfile;
use App\Models\Application;
use App\Models\GuideProfile;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\TourJob;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Settings
        Setting::set('site_name', 'Tour Base');
        Setting::set('site_tagline', 'Digital Job Matching Platform for Tour Guides');
        Setting::set('contact_email', 'info@tourbase.com');

        // Admin
        User::factory()->admin()->create([
            'name' => 'Admin Tour Base',
            'email' => 'admin@tourbase.com',
        ]);

        // Agencies (3)
        $agencies = collect();
        $agencyData = [
            ['name' => 'Nusantara Travel', 'email' => 'agency@tourbase.com'],
            ['name' => 'Borneo Adventures', 'email' => 'borneo@tourbase.com'],
            ['name' => 'MalayTravel Co', 'email' => 'malay@tourbase.com'],
        ];

        foreach ($agencyData as $data) {
            $user = User::factory()->agency()->create([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
            AgencyProfile::factory()->create([
                'user_id' => $user->id,
                'company_name' => $data['name'],
            ]);
            $agencies->push($user);
        }

        // Guides (5)
        $guides = collect();
        $guideData = [
            ['name' => 'Ahmad Razak', 'email' => 'guide@tourbase.com'],
            ['name' => 'Siti Aminah', 'email' => 'siti@tourbase.com'],
            ['name' => 'John Lim', 'email' => 'john@tourbase.com'],
            ['name' => 'Priya Devi', 'email' => 'priya@tourbase.com'],
            ['name' => 'Yusof Ali', 'email' => 'yusof@tourbase.com'],
        ];

        foreach ($guideData as $data) {
            $user = User::factory()->guide()->create([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
            GuideProfile::factory()->create(['user_id' => $user->id]);
            $guides->push($user);
        }

        // Tour Jobs (8) — spread across agencies
        $jobs = collect();
        foreach ($agencies as $agency) {
            $count = $agency->id === $agencies->first()->id ? 3 : 2;
            for ($i = 0; $i < $count; $i++) {
                $jobs->push(TourJob::factory()->create(['agency_id' => $agency->id]));
            }
        }
        // 1 pending job
        $jobs->push(TourJob::factory()->pending()->create(['agency_id' => $agencies->first()->id]));

        // Applications (10) — guides apply to jobs
        $applications = collect();
        foreach ($jobs->take(6) as $job) {
            $selectedGuides = $guides->random(min(2, $guides->count()));
            foreach ($selectedGuides as $guide) {
                $app = Application::create([
                    'tour_job_id' => $job->id,
                    'guide_id' => $guide->id,
                    'status' => fake()->randomElement(['pending', 'shortlisted', 'accepted']),
                    'applied_at' => now()->subDays(rand(1, 14)),
                ]);
                $applications->push($app);
            }
        }

        // Invoices (3) — for accepted applications
        $accepted = $applications->where('status', 'accepted')->take(3);
        foreach ($accepted as $app) {
            $job = TourJob::find($app->tour_job_id);
            Invoice::create([
                'application_id' => $app->id,
                'agency_id' => $job->agency_id,
                'guide_id' => $app->guide_id,
                'invoice_number' => Invoice::generateNumber(),
                'amount' => $job->fee,
                'tax' => 0,
                'total' => $job->fee,
                'payment_status' => fake()->randomElement(['pending', 'paid']),
                'issued_at' => now(),
            ]);
        }
    }
}
