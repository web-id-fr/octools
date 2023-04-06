<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\WorkspaceFactory;
use Webid\Octools\Models\Organization;
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

    public function createOctoolsWorkspaceForOrganization(
        Organization $organization,
        array $parameters = []
    ): Workspace
    {
        /** @var Workspace $workspace */
        $workspace = WorkspaceFactory::new()
            ->for($organization)
            ->create($parameters);

        return $workspace;
    }

}