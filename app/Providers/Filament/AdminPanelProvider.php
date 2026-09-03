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
                    .dark .fi-sidebar { background-color: #0b1120 !important; }
                    .dark .fi-main { background-color: #030712 !important; }
                    .dark .fi-topbar { background-color: #0b1120 !important; border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important; }
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
