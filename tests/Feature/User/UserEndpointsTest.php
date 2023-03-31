<?php

namespace Tests\Feature\User;

use Webid\Octools\Models\Application;
use Webid\Octools\Models\Organization;
use App\Models\User;
use Webid\Octools\Models\Workspace;
use Tests\TestCase;

class UserEndpointsTest extends TestCase
{
    /**
     * @test
     */
    public function can_call_user_index_endpoint()
    {
        $organization = Organization::factory()->create();
        $workspace = Workspace::factory()->create([
            'organization_id' => $organization->getKey(),
        ]);
        $app = Application::factory()->for($workspace, 'workspace')->create();
        User::factory()->count(4)->for($organization, 'organization')->create();

        $this->assertDatabaseCount('users', 4);

        $response =  $this->actingAsApplication($app)->get(route('users.index'))->assertSuccessful();
        $this->assertEquals(4, $response->getOriginalContent()->count());
    }

    /**
     * @test
     */
    public function can_call_user_show_endpoint()
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->for($organization, 'organization')->create();
        $workspace = Workspace::factory()->for($organization, 'organization')->create();
        $app = Application::factory()->for($workspace, 'workspace')->create();

        $this->actingAsApplication($app)->get(route('users.show', $user))
        ->assertStatus(200)
        ->assertJson([
            'email' => $user->email,
            'name' => $user->name,
            'isAdmin' => $user->isAdmin,
        ]);
    }
}
