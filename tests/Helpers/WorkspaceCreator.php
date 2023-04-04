<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\WorkspaceFactory;
use Webid\Octools\Models\Workspace;

trait WorkspaceCreator
{
    public function createOctoolsWorkspace(array $parameters = []): Workspace
    {
        /** @var Workspace $workspace */
        $workspace = WorkspaceFactory::new()
            ->create($parameters);

        return $workspace;
    }
}