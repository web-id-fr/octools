<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\MemberFactory;
use Webid\Octools\Models\Member;

trait MemberCreator
{
    public function createOctoolsMember(array $parameters = []): Member
    {
        /** @var Member $member */
        $member = MemberFactory::new()
            ->create($parameters);

        return $member;
    }
}