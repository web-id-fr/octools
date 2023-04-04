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
    /**
     * @test
     */
    public function can_call_user_index_endpoint()
    {
        $organization = $this->createOctoolsOrganization();
        $workspace = $this->createOctoolsWorkspace([
            'organization_id' => $organization->getKey(),
        ]);
        $app = $this->createOctoolsApplication(['workspace_id' => $workspace->getKey()]);

        for ($i = 0; $i <= 3; $i++) {
            $this->createOctoolsUser([
                'organization_id' => $organization->getKey()
            ]);
        }

        $this->assertDatabaseCount('users', 4);

        $response =  $this->actingAsApplication($app)->get(route('users.index'))->assertSuccessful();
        $this->assertEquals(4, $response->getOriginalContent()->count());
    }

    /**
     * @test
     */
    public function can_call_user_show_endpoint()
    {
        $organization = $this->createOctoolsOrganization();
        $user = $this->createOctoolsUser([
            'organization_id' => $organization->getKey()
        ]);
        $workspace = $this->createOctoolsWorkspace([
            'organization_id' => $organization->getKey()
        ]);
        $app = $this->createOctoolsApplication([
            'workspace_id' => $workspace->getKey()
        ]);

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
