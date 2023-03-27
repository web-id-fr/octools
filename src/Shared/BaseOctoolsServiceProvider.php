<?php

declare(strict_types=1);

namespace Webid\Octools\Shared;

use Illuminate\Support\ServiceProvider;
use Webid\Octools\Facades\Octools;
use Webid\Octools\OctoolsService;

abstract class BaseOctoolsServiceProvider extends ServiceProvider
{
    /**
     * Register service name
     *
     * @return string
     */
    abstract protected function serviceName(): string;

    /**
     * Register the key name identifying an user in the service
     *
     * @return string
     */
    abstract protected function memberKey(): string;

    /**
     * Register the service credentials keys
     *
     * @var array<string>
     */
    abstract protected function connectionConfigKeys(): array;

    /**
     * Register service provider path in order to auto-generate configs
     *
     * @return string
     */
    abstract protected function serviceProviderPath(): string;

    public function register(): void
    {
        $this->registerConfigs();

        $this->app->singleton("octools_{$this->serviceName()}", fn () => OctoolsService::make(
            $this->serviceName(),
            $this->memberKey(),
            $this->connectionConfigKeys(),
        ));
    }

    public function boot(): void
    {
        Octools::register($this->app->make("octools_{$this->serviceName()}"));

        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
        }
    }

    protected function registerConfigs(): void
    {
        $this->mergeConfigFrom(
            "{$this->serviceProviderPath()}/../config/octools-{$this->serviceName()}.php",
            "octools-{$this->serviceName()}",
        );
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            "{$this->serviceProviderPath()}/../config/octools-{$this->serviceName()}.php" => $this->app->configPath("octools-{$this->serviceName()}.php"),
        ], 'config');
    }
}
