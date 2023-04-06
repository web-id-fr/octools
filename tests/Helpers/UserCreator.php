<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\UserFactory;
use Tests\Setup\Models\User;
use Webid\Octools\Models\Organization;

trait UserCreator
{
    public function createOctoolsUser(array $parameters = []): User
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->create($parameters);

        return $user;
    }

    public function createOctoolsUserForOrganization(
        Organization $organization,
        array $parameters = []
    ): User
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->for($organization)
            ->create($parameters);

        return $user;
    }
}