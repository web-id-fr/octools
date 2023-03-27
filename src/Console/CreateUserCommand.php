<?php

declare(strict_types=1);

namespace Webid\Octools\Console;

use http\Exception\InvalidArgumentException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateUserCommand extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create an organization';

    public function handle(): int
    {
        try {
            $name = $this->ask('What is the user name ?');
            $this->validateString('name', $name);

            $email = $this->ask('What is the user email ?');
            $this->validateString('email', $email, 'email');

            $password = $this->ask('What is the user password ?');
            $this->validateString('password', $password);

            $organisationId = $this->ask('What is the user organisation id ?');
            $this->validateString('organization id', $organisationId, Rule::exists(config('octools.models.organization'), 'id'));
        } catch (\InvalidArgumentException $e) {
            $this->error("Specified name is invalid : {$e->getMessage()}");

            return self::FAILURE;
        }

        $now = now()->toDateTimeString();
        DB::table((new (config('octools.models.user')))->getTable())->insert([
            [
                'name' => $name,
                'email' => $email,
                'organization_id' => $organisationId,
                'password' => bcrypt($password),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        $this->info("User successfully created");

        return self::SUCCESS;
    }

    private function validateString(string $fieldName, mixed $name, mixed ...$additionnalRules): void
    {
        $validator = Validator::make(
            ['name' => $name],
            ['name' => ['required', 'string', 'min:1', 'max:255', ...$additionnalRules]],
        );

        if ($validator->fails()) {
            throw new InvalidArgumentException("Field {$fieldName} validation error : {$validator->messages()->first()}");
        }
    }
}
