<?php

namespace Tests\Feature\User;

use Tests\Helpers\ApplicationCreator;
use Tests\Helpers\OrganizationCreator;
use Tests\Helpers\UserCreator;
use Tests\Helpers\WorkspaceCreator;
use Webid\Octools\Models\Application;
use Webid\Octools\Models\Organization;
use Webid\Octools\Models\Workspace;
use Tests\TestCase;

class UserEndpointsTest extends TestCase
{
    use ApplicationCreator, WorkspaceCreator, UserCreator, OrganizationCreator;
    /** @test */
    public function can_call_user_index_endpoint()
    {
        $nbUsers = rand(2, 10);
        $organization = $this->createOctoolsOrganization();
        $workspace = $this->createOctoolsWorkspaceForOrganization($organization);
        $app = $this->createOctoolsApplicationForWorkspace($workspace);

        for ($i = 0; $i < $nbUsers; $i++) {
            $this->createOctoolsUserForOrganization($organization);
        }

        $this->assertDatabaseCount('users', $nbUsers);

        $response =  $this->actingAsApplication($app)->get(route('users.index'))->assertSuccessful();
        $this->assertEquals($nbUsers, $response->getOriginalContent()->count());
    }

    /** @test */
    public function can_call_user_show_endpoint()
    {
        $organization = $this->createOctoolsOrganization();
        $user = $this->createOctoolsUserForOrganization($organization);
        $workspace = $this->createOctoolsWorkspaceForOrganization($organization);
        $app = $this->createOctoolsApplicationForWorkspace($workspace);

        $this->actingAsApplication($app)->get(route('users.show', $user->getKey()))
            ->assertSuccessful()
            ->assertJson(
                [
                    'data' => [
                        'email' => $user->email,
                        'name' => $user->name,
                        'isAdmin' => $user->isAdmin,
                    ],
                ]
            );
    }
}
