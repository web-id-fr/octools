<?php

namespace Tests\Feature\Organization;

use Webid\Octools\Models\Application;
use Tests\TestCase;

class OrganizationEndpointsTest extends TestCase
{
    /**
     * @test
     */
    public function can_call_organization_show_endpoint()
    {
        $app = Application::factory()->create();

        $this->actingAsApplication($app)->get(route('organizations.show', $app))
        ->assertStatus(200)
        ->assertJson([
            'name' => $app->workspace->organization->name,
        ]);
    }
}
