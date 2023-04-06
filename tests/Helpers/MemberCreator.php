<?php

namespace Tests\Helpers;

use Tests\Setup\Factories\MemberFactory;
use Webid\Octools\Models\Member;
use Webid\Octools\Models\Workspace;

trait MemberCreator
{
    public function createOctoolsMember(array $parameters = []): Member
    {
        /** @var Member $member */
        $member = MemberFactory::new()
            ->create($parameters);

        return $member;
    }

    public function createOctoolsMemberForWorkspace(
        Workspace $workspace,
        array $parameters = []
    ): Member
    {
        /** @var Member $member */
        $member = MemberFactory::new()
            ->for($workspace)
            ->create($parameters);

        return $member;
    }
}