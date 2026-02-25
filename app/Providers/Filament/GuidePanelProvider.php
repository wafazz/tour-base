<?php

namespace App\Providers\Filament;

use App\Models\Setting;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Guide\Pages\Auth\GuideRegister;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class GuidePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('guide')
            ->path('guide')
            ->login()
            ->registration(GuideRegister::class)
            ->brandName(Setting::get('site_name', 'Tour Base') . ' Guide')
            ->brandLogo(Setting::get('logo') ? asset('storage/' . Setting::get('logo')) : null)
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Red,
                'info' => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Guide/Resources'), for: 'App\\Filament\\Guide\\Resources')
            ->discoverPages(in: app_path('Filament/Guide/Pages'), for: 'App\\Filament\\Guide\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Guide/Widgets'), for: 'App\\Filament\\Guide\\Widgets')
            ->widgets([
                \App\Filament\Guide\Widgets\GuideStatsOverview::class,
                \App\Filament\Guide\Widgets\GuideApplicationChart::class,
                \App\Filament\Guide\Widgets\GuideApplicationStatusChart::class,
                \App\Filament\Guide\Widgets\GuideLatestApplications::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
