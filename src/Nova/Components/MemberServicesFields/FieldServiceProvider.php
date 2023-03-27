<?php

declare(strict_types=1);

namespace Webid\Octools\Nova\Components\MemberServicesFields;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('member-services-fields', __DIR__ . '/dist/js/field.js');
        });
    }
}
