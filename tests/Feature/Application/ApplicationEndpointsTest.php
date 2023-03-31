<?php

namespace Tests\Feature\Application;

use Tests\Factories\ApplicationFactory;
use Webid\Octools\Models\Application;
use Tests\TestCase;

class ApplicationEndpointsTest extends TestCase
{
    /**
     * @test
     */
    public function can_call_application_show_endpoint()
    {
        $app = ApplicationFactory::factoryForModel(Application::class)->create();

        $this->actingAsApplication($app)->get(route('applications.show', $app))
        ->assertStatus(200)
        ->assertJson([
            'name' => $app->name,
            'token' => $app->token,
        ]);
    }

    /**
     * @test
     */
    public function can_call_application_update_endpoint()
    {
        $app = Application::factory()->create([
            'name' => 'Luigi',
        ]);

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
