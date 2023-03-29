<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Webid\Octools\Http\Requests\Api\UpdateApplicationRequest;
use Webid\Octools\Http\Resources\ApplicationResource;
use Webid\Octools\Models\Application;
use Webid\Octools\Repositories\ApplicationRepository;

class ApplicationController
{
    public function __construct(private ApplicationRepository $applicationRepository)
    {
    }

    /**
     * @throws AuthenticationException
     */
    public function show(): ApplicationResource
    {
        return ApplicationResource::make(loggedApplication()->load(['workspace']));
    }

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
