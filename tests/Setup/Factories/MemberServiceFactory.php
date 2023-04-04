<?php

namespace Tests\Setup\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Webid\Octools\Facades\Octools;
use Webid\Octools\Models\Member;
use Webid\Octools\Models\MemberService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<MemberService>
 */
class MemberServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'member_id' => Member::factory(),
            'service' => Octools::getServiceByKey('github')->name,
            'config' => "{'username':'CLEMREP'}",
        ];
    }
}
