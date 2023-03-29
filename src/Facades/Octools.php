<?php

declare(strict_types=1);

namespace Webid\Octools\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Webid\Octools\OctoolsService;

/**
 * @method static Collection<int, OctoolsService> getServices()
 * @method static OctoolsService getServiceByKey(string $serviceName)
 *
 * @method static void register(OctoolsService $name)
 *
 * @see \Webid\Octools\Octools
 */
class Octools extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'octools';
    }
}
