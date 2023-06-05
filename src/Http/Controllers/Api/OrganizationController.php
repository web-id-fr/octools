<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Auth\AuthenticationException;
use Webid\Octools\Http\Resources\OrganizationResource;
use Webid\Octools\OpenApi\Responses\ErrorUnauthenticatedResponse;
use Webid\Octools\OpenApi\Responses\OrganizationResponse;
use Webid\Octools\Repositories\OrganizationRepository;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class OrganizationController
{
    public function __construct(private OrganizationRepository $organizationRepository)
    {
    }

    /**
     * Get logged application organization.
     *
     * @throws AuthenticationException
     */
    #[OpenApi\Operation(id: 'getOrganization', tags: ['Organization'])]
    #[OpenApi\Response(factory: OrganizationResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    public function show(): OrganizationResource
    {
        return OrganizationResource::make(
            $this->organizationRepository->getOrganizationFromApplication(loggedApplication())
        );
    }
}
