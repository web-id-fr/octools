<?php

declare(strict_types=1);

namespace Webid\Octools\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Webid\Octools\Models\Application;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function showApi(Application $application): bool
    {
        return true;
    }

    public function updateApi(Application $loggedApp, Application $application): bool
    {
        return $loggedApp->getKey() === $application->getKey();
    }

    public function view($user, Application $application): bool
    {
        return $user->isAdmin || $user->organization->is($application->workspace->organization);
    }

    public function create($user): bool
    {
        return true;
    }

    public function update($user, Application $application): bool
    {
        return $user->isAdmin || $user->organization->is($application->workspace->organization);
    }

    public function delete($user, Application $application): bool
    {
        return $user->isAdmin || $user->organization->is($application->workspace->organization);
    }
}
