<?php

namespace Tests\Setup\Factories;

use App\Models\Enums\Services;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Webid\Octools\Facades\Octools;
use Webid\Octools\Models\Workspace;
use Webid\Octools\Models\WorkspaceService;
use Webid\Octools\OctoolsService;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<WorkspaceService>
 */
class WorkspaceServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $service = $this->faker->randomElement(Octools::getServices());

        return [
            'workspace_id' => Workspace::factory(),
            'service' => $service->value,
            'config' => $this->configForService($service),
        ];
    }

    private function configForService(OctoolsService $service): string
    {
        return match  ($service) {
            Octools::getServiceByKey('github') => "{'organization':'". $this->faker->company() ."','token':'". Str::random(80) ."'}",
            Octools::getServiceByKey('slack') => '{"token":"'.Str::random(80).'"}',
            Octools::getServiceByKey('gryzzly') => '{"token":"'.Str::random(80).'"}',
        };
    }
}
