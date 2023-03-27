<?php

declare(strict_types=1);

namespace Webid\Octools;

use Illuminate\Support\Collection;
use Webid\Octools\Exceptions\OctoolsServiceNotFound;

class Octools
{
    /** @var Collection<int, OctoolsService>|null */
    private ?Collection $services = null;

    public function register(OctoolsService $service): void
    {
        if (!$this->services) {
            $this->services = Collection::make([]);
        }

        $this->services->push($service);
    }

    /**
     * @return Collection<int, OctoolsService>
     */
    public function getServices(): Collection
    {
        return new Collection($this->services);
    }

    /**
     * @throws OctoolsServiceNotFound
     */
    public function getServiceByKey(string $serviceName): OctoolsService
    {
        $service = $this->services?->first(fn (OctoolsService $octoolsService) => $octoolsService->name === $serviceName);

        if ($service === null) {
            throw OctoolsServiceNotFound::fromName($serviceName);
        }

        return $service;
    }
}
