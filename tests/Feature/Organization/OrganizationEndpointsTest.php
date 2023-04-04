<?php

namespace Tests\Feature\Organization;

use Tests\Helpers\ApplicationCreator;
use Tests\Helpers\OrganizationCreator;
use Webid\Octools\Models\Application;
use Tests\TestCase;

class OrganizationEndpointsTest extends TestCase
{
    use ApplicationCreator;
    /**
     * @test
     */
    public function can_call_organization_show_endpoint()
    {
        $app = $this->createOctoolsApplication();

        $this->actingAsApplication($app)->get(route('organizations.show', $app))
        ->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $app->workspace->organization->getKey(),
                        'name' => $app->workspace->organization->name,
                    ],
                ]
            );
    }
}
