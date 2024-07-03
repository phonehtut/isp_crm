<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\ThemesPlugin;
use App\Filament\Clusters\Settings;
use Filament\Support\Enums\MaxWidth;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Awcodes\FilamentVersions\VersionsPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Filament\Billing\Providers\SparkBillingProvider;
use TomatoPHP\FilamentBrowser\FilamentBrowserPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider
{
    protected static ?string $cluster = Settings::class;

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Indigo,
                'info' => Color::Sky,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
                'danger' => Color::Red,
                'gray' => Color::Gray,
                'white' => Color::Slate,
            ])
            ->maxContentWidth(MaxWidth::Full)
            ->globalSearch(false)
            ->sidebarCollapsibleOnDesktop()
            ->spa()
            ->unsavedChangesAlerts()
            ->databaseTransactions()
            ->tenantBillingProvider(new SparkBillingProvider())
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle'),
                'Chat' => MenuItem::make()
                    ->label('Chat')
                    ->url('/chat')
                    ->icon('heroicon-o-chat-bubble-oval-left-ellipsis')
                    ->openUrlInNewTab(true)
            ])
            ->NavigationGroups([
                NavigationGroup::make('Ticket Settings'),
            ])
            ->globalSearchKeyBindings(['command+f', 'ctrl+f'])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //
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
                SetTheme::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('2s')
            ->plugins([
                FilamentEditProfilePlugin::make()
                   ->slug('my-profile')
                   ->setTitle('My Profile')
                   ->shouldRegisterNavigation(false)
                   ->shouldShowDeleteAccountForm(false)
                   ->shouldShowBrowserSessionsForm()
                   ->shouldShowAvatarForm(),
                ThemesPlugin::make(),
                VersionsPlugin::make(),
                QuickCreatePlugin::make()
                    ->label('New')
                    ->slideOver(),
                FilamentBrowserPlugin::make(),
                FilamentApexChartsPlugin::make(),
                FilamentEnvEditorPlugin::make()
                    ->navigationGroup('Settings')
                    ->navigationLabel('My Env')
                    ->navigationIcon('heroicon-o-cog-8-tooth')
                    ->navigationSort(1)
                    ->slug('env-editor'),
                FilamentShieldPlugin::make(),
            ]);
    }
}
