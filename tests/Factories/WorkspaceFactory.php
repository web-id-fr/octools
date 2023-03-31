<?php

namespace Tests\Factories;

use Webid\Octools\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\Octools\Models\Workspace;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Workspace>
 */
class WorkspaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'organization_id' => Organization::factory(),
        ];
    }
}
