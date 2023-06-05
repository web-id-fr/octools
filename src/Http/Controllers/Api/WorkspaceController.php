<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Auth\AuthenticationException;
use Webid\Octools\Http\Resources\WorkspaceResource;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use Webid\Octools\OpenApi\Responses\ErrorUnauthenticatedResponse;
use Webid\Octools\OpenApi\Responses\WorkspaceResponse;

#[OpenApi\PathItem]
class WorkspaceController
{
    /**
     * Get workspace.
     *
     * @throws AuthenticationException
     */
    #[OpenApi\Operation(id: 'getWorkspace', tags: ['Workspace'])]
    #[OpenApi\Response(factory: WorkspaceResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    public function show(): WorkspaceResource
    {
        $workspace = loggedApplication()->workspace;

        return WorkspaceResource::make(
            $workspace->load(['organization', 'services', 'members'])
        );
    }
}
