<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->sidebarCollapsibleOnDesktop()
            ->brandName('IEE 2026')
            ->brandLogo(asset('images/Logo.png'))
            ->brandLogoHeight('2.5rem')
            ->favicon(asset('images/Logo.png'))
            ->font('Exo 2')
            ->defaultThemeMode(\Filament\Enums\ThemeMode::Dark)
            ->colors([
                'primary' => \Filament\Support\Colors\Color::hex('#FFC209'),
                'gray' => [
                    50 => '#f0f3fa',
                    100 => '#e3e8f5',
                    200 => '#cdd7ed',
                    300 => '#adbee0',
                    400 => '#889ecd',
                    500 => '#6a81b9',
                    600 => '#5264a2',
                    700 => '#435185',
                    800 => '#111827',
                    900 => '#0a0f1d',
                    950 => '#050811',
                ],
            ])
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
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
