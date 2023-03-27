<?php

declare(strict_types=1);

namespace Webid\Octools;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Webid\Octools\Console\CreateOrganisationCommand;
use Webid\Octools\Console\CreateUserCommand;
use Webid\Octools\Nova\Application;
use Webid\Octools\Nova\Components\MemberServicesFields\FieldServiceProvider as MemberFieldServiceProvider;
use Webid\Octools\Nova\Components\Welcome\CardServiceProvider;
use Webid\Octools\Nova\Components\WorkspaceServicesFields\FieldServiceProvider as WorkspaceFieldServiceProvider;
use Webid\Octools\Nova\Member;
use Webid\Octools\Nova\MemberService;
use Webid\Octools\Nova\Organization;
use Webid\Octools\Nova\User;
use Webid\Octools\Nova\Workspace;
use Webid\Octools\Nova\WorkspaceService;

class OctoolsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/octools.php', 'octools');
        $this->mergeConfigFrom(__DIR__ . '/../config/octools-auth-guards.php', 'auth.guards');
        $this->mergeConfigFrom(__DIR__ . '/../config/octools-auth-providers.php', 'auth.providers');

        $this->app->register(MemberFieldServiceProvider::class);
        $this->app->register(WorkspaceFieldServiceProvider::class);
        $this->app->register(CardServiceProvider::class);

        $this->registerFacade();
        $this->registerHelpers();

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateOrganisationCommand::class,
                CreateUserCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        $this->registerRoutes();
        $this->registerViews();
        $this->registerTranslations();

        $this->overrideNovaConfigurations();

        Nova::serving(function () {
            $this->bootNova();
        });

        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
        }
    }

    protected function registerRoutes(): void
    {
        Route::group([], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/auth.php');
        });
    }

    protected function registerFacade(): void
    {
        $this->app->singleton('octools', function () {
            return $this->app->make(Octools::class);
        });
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/Resources/views', 'octools');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom($this->app->langPath('vendor/octools'), 'octools');
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../config/octools.php' => $this->app->configPath('octools.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . "/../database/migrations/create_octools_tables.php" => $this->app->databasePath('migrations/'. Carbon::now()->format('Y_m_d_His', time())."_create_octools_tables.php"),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/css' => $this->app->publicPath('vendor/octools'),
            __DIR__.'/../resources/img/Octools_logo_text.svg' => $this->app->publicPath('vendor/octools/Octools_logo_text.svg'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../resources/lang' => $this->app->langPath('vendor/octools'),
        ], 'lang');
    }

    private function overrideNovaConfigurations(): void
    {
        $novaOverrides = $this->app['config']->get('octools.nova.overrides', []);

        foreach ($novaOverrides as $overrideName => $novaOverride) {
            $this->app['config']->set("nova.{$overrideName}", $novaOverride);
        }
    }

    protected function bootNova(): void
    {
        User::$model = $this->app['config']->get('octools.models.user');
        Application::$model = $this->app['config']->get('octools.models.application');
        Member::$model = $this->app['config']->get('octools.models.member');
        MemberService::$model = $this->app['config']->get('octools.models.member_service');
        Organization::$model = $this->app['config']->get('octools.models.organization');
        Workspace::$model = $this->app['config']->get('octools.models.workspace');
        WorkspaceService::$model = $this->app['config']->get('octools.models.workspace_service');

        Nova::resources([
            User::class,
            Application::class,
            Member::class,
            MemberService::class,
            Organization::class,
            Workspace::class,
            WorkspaceService::class,
        ]);

        Nova::$dashboards = [new (config('octools.nova.dashboard_class'))];

        Nova::mainMenu(fn () => [
            MenuSection::dashboard(config('octools.nova.dashboard_class'))->icon('chart-bar'),

            ...array_map(function (string $icon, string $resourceClass) {
                return MenuSection::resource($resourceClass)->icon($icon);
            }, config('octools.nova.menus'), array_keys(config('octools.nova.menus'))),
        ]);
    }

    private function registerHelpers(): void
    {
        $path = __DIR__ . '/helpers.php';

        if (file_exists($path)) {
            include_once($path);
        }
    }
}
