<?php

declare(strict_types=1);

namespace Webid\Octools\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Webid\Octools\Models\Application;
use Webid\Octools\Models\Workspace;

class WorkspacePolicy
{
    use HandlesAuthorization;

    public function showApi(Application $application): bool
    {
        return true;
    }

    public function view($user, Workspace $workspace): bool
    {
        return $user->isAdmin || $user->organization->is($workspace->organization);
    }

    public function create($user): bool
    {
        return true;
    }

    public function update($user, Workspace $workspace): bool
    {
        return $user->isAdmin || $user->organization->is($workspace->organization);
    }

    public function delete($user, Workspace $workspace): bool
    {
        return $user->isAdmin || $user->organization->is($workspace->organization);
    }
}
