<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn () => new HtmlString('
                <link rel="manifest" href="/manifest.webmanifest">
                <meta name="theme-color" content="#1B2A4A">
                <meta name="apple-mobile-web-app-capable" content="yes">
                <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
                <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
            ')
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            fn () => new HtmlString('
                <script>
                    if ("serviceWorker" in navigator) {
                        navigator.serviceWorker.register("/sw.js");
                    }
                </script>
            ')
        );
    }
}
