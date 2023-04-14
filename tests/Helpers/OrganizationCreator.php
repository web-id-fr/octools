<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\OrganizationFactory;
use Webid\Octools\Models\Organization;

trait OrganizationCreator
{
    public function createOctoolsOrganization(array $parameters = []): Organization
    {
        /** @var Organization $organization */
        $organization = OrganizationFactory::new()
            ->create($parameters);

        return $organization;
    }
}