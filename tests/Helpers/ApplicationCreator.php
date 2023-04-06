<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\ApplicationFactory;
use Webid\Octools\Models\Application;
use Webid\Octools\Models\Workspace;

trait ApplicationCreator
{
    public function createOctoolsApplication(array $parameters = []): Application
    {
        /** @var Application $application */
        $application = ApplicationFactory::new()
            ->create($parameters);

        return $application;
    }

    public function createOctoolsApplicationForWorkspace(
        Workspace $workspace,
        array $parameters = []
    ): Application
    {
        /** @var Application $application */
        $application = ApplicationFactory::new()
            ->for($workspace)
            ->create($parameters);

        return $application;
    }
}