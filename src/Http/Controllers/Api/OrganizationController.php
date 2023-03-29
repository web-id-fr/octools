<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Auth\AuthenticationException;
use Webid\Octools\Http\Resources\OrganizationResource;
use Webid\Octools\Repositories\OrganizationRepository;

class OrganizationController
{
    public function __construct(private OrganizationRepository $organizationRepository)
    {
    }

    /**
     * @throws AuthenticationException
     */
    public function show(): OrganizationResource
    {
        return OrganizationResource::make(
            $this->organizationRepository->getOrganizationFromApplication(loggedApplication())
        );
    }
}
