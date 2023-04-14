<?php

declare(strict_types=1);

namespace Webid\Octools\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Webid\Octools\Models\Application;

class UserPolicy
{
    use HandlesAuthorization;

    public function showApi(Application $application, $user): bool
    {
        return $application->workspace->organization->is($user->organization);
    }

    public function view($loggedUser, $user): bool
    {
        return $loggedUser->isAdmin || $loggedUser->organization->is($user->organization);
    }

    public function create($loggedUser): bool
    {
        return true;
    }

    public function update($loggedUser, $user): bool
    {
        return $loggedUser->isAdmin || $loggedUser->organization->is($user->organization);
    }

    public function delete($loggedUser, $user): bool
    {
        return $loggedUser->isAdmin || $loggedUser->organization->is($user->organization);
    }
}
