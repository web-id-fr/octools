<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Auth\AuthenticationException;
use Webid\Octools\Http\Resources\WorkspaceResource;

class WorkspaceController
{
    /**
     * @throws AuthenticationException
     */
    public function show(): WorkspaceResource
    {
        $workspace = loggedApplication()->workspace;

        return WorkspaceResource::make(
            $workspace->load(['organization', 'services', 'members'])
        );
    }
}
