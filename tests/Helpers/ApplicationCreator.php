<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\ApplicationFactory;
use Webid\Octools\Models\Application;

trait ApplicationCreator
{
    public function createOctoolsApplication(array $parameters = []): Application
    {
        /** @var Application $application */
        $application = ApplicationFactory::new()
            ->create($parameters);

        return $application;
    }
}