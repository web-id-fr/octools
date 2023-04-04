<?php

namespace Tests\Setup\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Webid\Octools\Models\Application;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Application>
 */
class ApplicationFactory extends Factory
{

    protected $model = Application::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $token = Str::random(128);
        return [
            'name' => $this->faker->name(),
            'token' => $token,
            'api_token' => hash('sha256', $token),
            'workspace_id' => WorkspaceFactory::new()->create(),
        ];
    }
}
