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
                    .dark .fi-sidebar { background-color: #0b1120 !important; }
                    .dark .fi-main { background-color: #030712 !important; }
                    .dark .fi-topbar { background-color: #0b1120 !important; border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important; }
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
