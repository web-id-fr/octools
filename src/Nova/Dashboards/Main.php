<?php

namespace Webid\Octools\Nova\Dashboards;

use Laravel\Nova\Dashboards\Main as Dashboard;
use Webid\Octools\Nova\Components\Welcome\Welcome;

class Main extends Dashboard
{
    public function name(): string
    {
        return __('octools::resources.dashboard');
    }

    public function cards(): array
    {
        return [
            new Welcome(),
        ];
    }
}
