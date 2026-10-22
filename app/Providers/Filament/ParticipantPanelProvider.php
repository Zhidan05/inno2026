<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Participant\Widgets\ParticipantOverviewWidget;

class ParticipantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('participant')
            ->path('participant')
            ->login(false)
            ->sidebarCollapsibleOnDesktop()
            ->brandName('IEE 2026')
            ->brandLogo(asset('images/Logo.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('images/Logo.png'))
            ->font('Exo 2')
            ->defaultThemeMode(\Filament\Enums\ThemeMode::Dark)
            ->renderHook(
                \Filament\View\PanelsRenderHook::HEAD_END,
                fn (): string => '<style>
                    body, .fi-body { background-color: #050816 !important; }
                    .dark .fi-main { background-color: #050816 !important; }
                    .dark .fi-sidebar { background-color: rgba(10, 15, 30, 0.92) !important; border-right: 1px solid rgba(255, 255, 255, 0.08) !important; backdrop-filter: blur(16px) !important; -webkit-backdrop-filter: blur(16px) !important; }
                    .dark .fi-topbar { background-color: rgba(15, 23, 42, 0.45) !important; border-bottom: 1px solid rgba(255, 255, 255, 0.10) !important; backdrop-filter: blur(20px) !important; -webkit-backdrop-filter: blur(20px) !important; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.36) !important; }
                    .dark .fi-topbar nav { background: transparent !important; }
                    .dark .fi-section, .dark .fi-wi-stats-overview-stat, .dark .fi-ta-ctn { background-color: rgba(15, 23, 42, 0.50) !important; border: 1px solid rgba(255, 255, 255, 0.10) !important; backdrop-filter: blur(12px) !important; -webkit-backdrop-filter: blur(12px) !important; border-radius: 1rem !important; }
                </style>'
            )
            ->colors([
                'primary' => Color::Sky,
            ])
            ->discoverResources(in: app_path('Filament/Participant/Resources'), for: 'App\\Filament\\Participant\\Resources')
            ->discoverPages(in: app_path('Filament/Participant/Pages'), for: 'App\\Filament\\Participant\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Participant/Widgets'), for: 'App\\Filament\\Participant\\Widgets')
            ->widgets([
                ParticipantOverviewWidget::class,
            ])
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
