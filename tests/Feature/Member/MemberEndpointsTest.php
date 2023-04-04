<?php

namespace Tests\Feature\Member;

use Tests\Helpers\ApplicationCreator;
use Tests\Helpers\MemberCreator;
use Tests\Helpers\WorkspaceCreator;
use Webid\Octools\Models\Member;
use Tests\TestCase;

class MemberEndpointsTest extends TestCase
{
    use ApplicationCreator;
    use MemberCreator;
    use WorkspaceCreator;

    /**
     * @test
     */
    public function can_call_member_index_endpoint()
    {
        $app = $this->createOctoolsApplication();
        for ($i = 0; $i <= 3; $i++)
        {
            $this->createOctoolsMember(['workspace_id' => $app->workspace->getKey()]);
        }

        $this->assertDatabaseCount('members', 4);

        $response = $this->actingAsApplication($app)->get(route('members.index'))->assertSuccessful();
        $this->assertCount(4, $response->json()['data']);
    }

    /**
     * @test
     */
    public function can_call_member_store_endpoint()
    {
        $app = $this->createOctoolsApplication();
        $this->assertDatabaseCount('members', 0);

        $response = $this->actingAsApplication($app)->post(route('members.store', [
            'firstname' => 'Clément',
            'lastname' => 'REPEL',
            'email' => 'clement@web-id.fr',
            'birthdate' => '25-06-2003',
            'workspace_id' => $this->createOctoolsWorkspace()->getKey(),
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
        $app = $this->createOctoolsApplication();

        $member = $this->createOctoolsMember(['workspace_id' => $app->workspace->getKey()]);

        $this->actingAsApplication($app)->get(route('members.show', $member->getKey()))
            ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'email' => $member->email,
                        'firstname' => $member->firstname,
                        'lastname' => $member->lastname,
                    ],
                ]
            );
    }

    /**
     * @test
     */
    public function can_call_member_update_endpoint()
    {
        $app = $this->createOctoolsApplication();
        $member = $this->createOctoolsMember(['workspace_id' => $app->workspace->getKey()]);

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
        $app = $this->createOctoolsApplication();
        $member = $this->createOctoolsMember(['workspace_id' => $app->workspace->getKey()]);

        $this->assertDatabaseCount('members', 1);

        $response = $this->actingAsApplication($app)->delete(route('members.destroy', $member));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'Member deleted with success',
        ]);







        $this->assertDatabaseCount('members', 0);
    }
}
