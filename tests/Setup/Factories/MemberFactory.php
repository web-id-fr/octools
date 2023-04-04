<?php

namespace Tests\Setup\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\Octools\Models\Member;
use Webid\Octools\Models\Workspace;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->email(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'birthdate' => $this->faker->date('d-m-Y'),
            'workspace_id' => WorkspaceFactory::new(),
        ];
    }
}
