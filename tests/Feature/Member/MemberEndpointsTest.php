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

    /** @test */
    public function can_call_member_index_endpoint()
    {
        $app = $this->createOctoolsApplication();
        $nbMembers = rand(2, 10);

        for ($i = 0; $i < $nbMembers; $i++)
        {
            $this->createOctoolsMember(['workspace_id' => $app->workspace->getKey()]);
        }

        $this->assertDatabaseCount('members', $nbMembers);

        $response = $this->actingAsApplication($app)->get(route('members.index'))->assertSuccessful();
        $this->assertCount($nbMembers, $response->json()['data']);
    }

    /** @test */
    public function can_call_member_store_endpoint()
    {
        $app = $this->createOctoolsApplication();
        $this->assertDatabaseCount('members', 0);

        $response = $this->actingAsApplication($app)->post(route('members.store', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@doe.fr',
            'birthdate' => '25-06-1999',
            'workspace_id' => $app->workspace->getKey(),
        ]));

        $response->assertStatus(200)->assertJson([
            'success' => 'Member created with success',
        ]);

        $this->assertDatabaseCount('members', 1);
    }

    /** @test */
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

    /** @test */
    public function can_call_member_update_endpoint()
    {
        $app = $this->createOctoolsApplication();
        $member = $this->createOctoolsMember(['workspace_id' => $app->workspace->getKey()]);

        $this->actingAsApplication($app)
            ->put(
                route('members.update', $member),
                [
                    'firstname' => 'John',
                    'lastname' => 'Doe',
                ]
            )
            ->assertStatus(200)
            ->assertJson([
                'success' => 'Member updated with success',
            ]);

        $this->assertNotEquals('John', $member->firstname);
        $this->assertNotEquals('Doe', $member->lastname);
    }

    /** @test */
    public function can_call_member_delete_endpoint()
    {
        Member::getEventDispatcher();
        $app = $this->createOctoolsApplication();
        $member = $this->createOctoolsMemberForWorkspace($app->workspace);

        $this->assertDatabaseCount('members', 1);

        $response = $this->actingAsApplication($app)->delete(route('members.destroy', $member));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => 'Member deleted with success',
        ]);

        $this->assertDatabaseCount('members', 0);
    }
}
