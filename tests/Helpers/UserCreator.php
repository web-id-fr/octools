<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\UserFactory;
use Tests\Setup\Models\User;

trait UserCreator
{
    public function createOctoolsUser(array $parameters = []): User
    {
        /** @var User $user */
        $user = UserFactory::new()
            ->create($parameters);

        return $user;
    }
}