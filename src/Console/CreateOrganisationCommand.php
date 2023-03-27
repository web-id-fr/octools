<?php

declare(strict_types=1);

namespace Webid\Octools\Console;

use http\Exception\InvalidArgumentException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateOrganisationCommand extends Command
{
    protected $signature = 'organization:create';

    protected $description = 'Create an organization';

    public function handle(): int
    {
        $name = $this->ask('What is the organization name ?');

        try {
            $this->validateName($name);
        } catch (\InvalidArgumentException $e) {
            $this->error("Specified name is invalid : {$e->getMessage()}");

            return self::FAILURE;
        }

        $organization = config('octools.models.organization')::create(['name' => $name]);

        $this->info("Organization #{$organization->getKey()} \"{$organization->name}\" successfully created");

        return self::SUCCESS;
    }

    private function validateName(mixed $name): void
    {
        $validator = Validator::make(
            ['name' => $name],
            ['name' => ['required', 'string', 'min:0', 'max:255']],
        );

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->messages()->first());
        }
    }
}
