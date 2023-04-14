<?php

namespace Tests\Feature\Workspace;

use Tests\Helpers\ApplicationCreator;
use Tests\Helpers\WorkspaceCreator;
use Tests\TestCase;

class WorkspaceEndpointsTest extends TestCase
{
    use ApplicationCreator, WorkspaceCreator;
    /** @test */
    public function can_call_workspace_show_endpoint()
    {
        $app = $this->createOctoolsApplication();

        $this->actingAsApplication($app)
        ->get(route('workspaces.show'))
        ->assertStatus(200)
        ->assertJson(
            [
                'data' => [
                    'id' => $app->workspace->getKey(),
                    'name' => $app->workspace->name,
                ],
            ]
        );
    }
}
