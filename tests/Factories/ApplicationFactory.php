<?php

namespace Tests\Factories;

use Webid\Octools\Models\Application;
use Webid\Octools\Models\Workspace;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'workspace_id' => Workspace::factory(),
        ];
    }
}
