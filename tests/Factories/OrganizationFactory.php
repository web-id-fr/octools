<?php

namespace Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\Octools\Models\Organization;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Organization>
 */
class OrganizationFactory extends Factory
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
        ];
    }
}
