<?php

declare(strict_types=1);

namespace Webid\Octools\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Webid\Octools\Models\Application;
use Webid\Octools\Models\Member;

class MemberPolicy
{
    use HandlesAuthorization;

    public function indexApi(Application $application): bool
    {
        return true;
    }

    public function showApi(Application $application, Member $member): bool
    {
        return $application->workspace->is($member->workspace);
    }

    public function storeApi(Application $application): bool
    {
        return true;
    }

    public function updateApi(Application $application, Member $member): bool
    {
        return $application->workspace->is($member->workspace);
    }

    public function deleteApi(Application $application, Member $member): bool
    {
        return $application->workspace->is($member->workspace);
    }

    public function view($user, Member $member): bool
    {
        return $user->isAdmin || $user->organization->is($member->workspace->organization);
    }

    public function create($user): bool
    {
        return true;
    }

    public function update($user, Member $member): bool
    {
        return $user->isAdmin || $user->organization->is($member->workspace->organization);
    }

    public function delete($user, Member $member): bool
    {
        return $user->isAdmin || $user->organization->is($member->workspace->organization);
    }
}
