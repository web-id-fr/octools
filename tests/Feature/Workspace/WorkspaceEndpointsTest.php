<?php

namespace Tests\Feature\Workspace;

use Webid\Octools\Models\Application;
use Webid\Octools\Models\Workspace;
use Tests\TestCase;

class WorkspaceEndpointsTest extends TestCase
{
    /**
     * @test
     */
    public function can_call_workspace_show_endpoint()
    {
        $workspace = Workspace::factory()->create();
        $app = Application::factory()->for($workspace, 'workspace')->create();

        $this->actingAsApplication($app)
        ->get(route('workspaces.show'))
        ->assertStatus(200)
        ->assertJson([
                "id" => $workspace->getKey(),
                "name" => $workspace->name,
        ]);
    }
}
