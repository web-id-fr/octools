<?php

namespace Tests\Feature\Application;

use Tests\Helpers\ApplicationCreator;
use Tests\Setup\Factories\ApplicationFactory;
use Tests\TestCase;
use function PHPUnit\Framework\assertJson;

class ApplicationEndpointsTest extends TestCase
{
    use ApplicationCreator;
    /** @test */
    public function can_call_application_show_endpoint()
    {
        $app = $this->createOctoolsApplication();

        $this->actingAsApplication($app)->get(route('applications.show', $app))
        ->assertStatus(200)
        ->assertJson(
            [
                'data' => [
                    'name' => $app->name,
                    'token' => $app->token,
                ],
            ]
        );
    }

    /** @test */
    public function can_call_application_update_endpoint()
    {
        $app = $this->createOctoolsApplication(
            ['name' => 'Luigi']
        );

        $this->actingAsApplication($app)
            ->put(
                route('applications.update', $app),
                ['name' => 'New APP']
            )
        ->assertStatus(200)
        ->assertJson([
            'success' => 'Application updated with success',
        ]);

        $app->refresh();
        $this->assertNotEquals('Luigi', $app->name);
        $this->assertEquals('New APP', $app->name);
    }
}
