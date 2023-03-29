<?php

declare(strict_types=1);

namespace Webid\Octools\Repositories;

use Webid\Octools\Models\Application;
use Webid\Octools\Models\Organization;

class OrganizationRepository
{
    public function getOrganizationFromApplication(Application $application): Organization
    {
        return $application->workspace->organization->load(['workspaces', 'users']);
    }
}
