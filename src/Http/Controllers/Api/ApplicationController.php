<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Webid\Octools\Http\Requests\Api\UpdateApplicationRequest;
use Webid\Octools\Http\Resources\ApplicationResource;
use Webid\Octools\Models\Application;
use Webid\Octools\OpenApi\RequestBodies\UpdateApplicationRequestBody;
use Webid\Octools\OpenApi\Responses\ErrorNotFoundResponse;
use Webid\Octools\OpenApi\Responses\ErrorUnauthenticatedResponse;
use Webid\Octools\OpenApi\Responses\ErrorUnauthorizedResponse;
use Webid\Octools\OpenApi\Responses\ApplicationResponse;
use Webid\Octools\OpenApi\Responses\ErrorValidationResponse;
use Webid\Octools\OpenApi\Responses\UpdatedResponse;
use Webid\Octools\Repositories\ApplicationRepository;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class ApplicationController
{
    public function __construct(private ApplicationRepository $applicationRepository)
    {
    }

    /**
     * Get logged application.
     *
     * @throws AuthenticationException
     */
    #[OpenApi\Operation(tags: ['Application'])]
    #[OpenApi\Response(factory: ApplicationResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    public function show(): ApplicationResource
    {
        return ApplicationResource::make(loggedApplication()->load(['workspace']));
    }

    /**
     * Update application.
     *
     * @param Application $application Application ID
     */
    #[OpenApi\Operation(tags: ['Application'])]
    #[OpenApi\RequestBody(factory: UpdateApplicationRequestBody::class)]
    #[OpenApi\Response(factory: UpdatedResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: ErrorNotFoundResponse::class, statusCode: 404)]
    public function update(UpdateApplicationRequest $request, Application $application): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->applicationRepository->updateApplication($data, $application);

        return response()->json([
            'success' => 'Application updated with success',
        ], 200);
    }
}
