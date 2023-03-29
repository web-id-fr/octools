<?php

declare(strict_types=1);

namespace Webid\Octools\Shared;

use Illuminate\Support\ServiceProvider;
use Webid\Octools\Facades\Octools;
use Webid\Octools\OctoolsService;

abstract class BaseOctoolsServiceProvider extends ServiceProvider
{
    protected OctoolsService $service;

    /**
     * Register service
     *
     * @return OctoolsService
     */
    abstract protected function service(): OctoolsService;

    /**
     * Register service provider path in order to auto-generate configs
     *
     * @return string
     */
    abstract protected function serviceProviderPath(): string;

    public function register(): void
    {
        $this->service = $this->service();

        $this->registerConfigs();
    }

    public function boot(): void
    {
        Octools::register($this->service);

        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
        }
    }

    protected function registerConfigs(): void
    {
        $this->mergeConfigFrom(
            "{$this->serviceProviderPath()}/../config/octools-{$this->service->name}.php",
            "octools-{$this->service->name}",
        );
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            "{$this->serviceProviderPath()}/../config/octools-{$this->service->name}.php" => $this->app->configPath("octools-{$this->service->name}.php"),
        ], 'config');
    }

    private function registerRoutes(): void
    {
        if (file_exists($path = $this->serviceProviderPath() . '/Routes/api.php')) {
            $this->loadRoutesFrom($path);
        }
    }
}
