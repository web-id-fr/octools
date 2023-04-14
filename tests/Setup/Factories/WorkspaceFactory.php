<?php

namespace Tests\Setup\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\Octools\Models\Workspace;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Workspace>
 */
class WorkspaceFactory extends Factory
{
    protected $model = Workspace::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'organization_id' => OrganizationFactory::new()->create(),
        ];
    }
}
