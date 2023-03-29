<?php

declare(strict_types=1);

namespace Webid\Octools\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Webid\Octools\Models\Application;
use Webid\Octools\Models\Organization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    public function showApi(Application $application): bool
    {
        return true;
    }

    public function view($user, Organization $organization): bool
    {
        return $user->isAdmin || $user->organization->is($organization);
    }

    public function create($user): bool
    {
        return (bool) $user->isAdmin;
    }

    public function update($user, Organization $organization): bool
    {
        return $user->isAdmin || $user->organization->is($organization);
    }

    public function delete($user, Organization $organization): bool
    {
        return $user->isAdmin || $user->organization->is($organization);
    }
}
