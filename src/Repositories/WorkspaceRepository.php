<?php

namespace App\Repositories;

use Webid\Octools\Models\Workspace;

class WorkspaceRepository
{
    public function __construct(private Workspace $model)
    {
    }

    public function findWorkspaceById(int $workspaceId): Workspace|null
    {
        /** @var Workspace $workspace */
        $workspace = $this->model->newQuery()->find($workspaceId);

        return $workspace;
    }
}
