<?php

namespace Webid\Octools\Nova\Components\Welcome;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('welcome', __DIR__ . '/dist/js/card.js');
            Nova::style('welcome', __DIR__ . '/dist/css/card.css');
        });
    }
}
