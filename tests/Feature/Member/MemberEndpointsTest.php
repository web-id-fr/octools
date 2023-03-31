<?php

namespace Tests\Feature\Member;

use Webid\Octools\Models\Application;
use Webid\Octools\Models\Member;
use Webid\Octools\Models\Workspace;
use Tests\TestCase;

class MemberEndpointsTest extends TestCase
{
    /**
     * @test
     */
    public function can_call_member_index_endpoint()
    {
        $app = Application::factory()->create();
        Member::factory()->count(4)->for($app->workspace, 'workspace')->createQuietly();

        $this->assertDatabaseCount('members', 4);

        $response = $this->actingAsApplication($app)->get(route('members.index'))->assertSuccessful();
        $response->assertJsonCount(4);
    }

    /**
     * @test
     */
    public function can_call_member_store_endpoint()
    {
        $app = Application::factory()->create();
        $this->assertDatabaseCount('members', 0);

        $response = $this->actingAsApplication($app)->post(route('members.store', [
            'firstname' => 'Clément',
            'lastname' => 'REPEL',
            'email' => 'clement@web-id.fr',
            'birthdate' => '25-06-2003',
            'workspace_id' => Workspace::factory()->create()->getKey(),
        ]));

        $response->assertStatus(200)->assertJson([
            'success' => 'Member created with success',
        ]);

        $this->assertDatabaseCount('members', 1);
    }

    /**
     * @test
     */
    public function can_call_member_show_endpoint()
    {
        $app = Application::factory()->create();
        $member = Member::factory()->for($app->workspace, 'workspace')->createQuietly();

        $this->actingAsApplication($app)->get(route('members.show', $member))
        ->assertStatus(200)
        ->assertJson([
            'email' => $member->email,
            'firstname' => $member->firstname,
            'lastname' => $member->lastname,
        ]);
    }

    /**
     * @test
     */
    public function can_call_member_update_endpoint()
    {
        $app = Application::factory()->create();
        $member = Member::factory()->for($app->workspace, 'workspace')->createQuietly();

        $this->actingAsApplication($app)
            ->put(
                route('members.update', $member),
                ['email' => 'clement@web-id.fr']
            )
        ->assertStatus(200)
        ->assertJson([
            'success' => 'Member updated with success',
        ]);

        $this->assertNotEquals('clement@web-id.fr', $member->email);
    }

    /**
     * @test
     */
    public function can_call_member_delete_endpoint()
    {
        Member::getEventDispatcher();
        $app = Application::factory()->create();
        $member = Member::factory()->for($app->workspace, 'workspace')->createQuietly();

        $this->assertDatabaseCount('members', 1);

        $this->actingAsApplication($app)->delete(route('members.destroy', $member))
            ->assertStatus(200)
            ->assertJson([
                'success' => 'Member deleted with success',
            ]);

        $this->assertDatabaseCount('members', 0);
    }
}
