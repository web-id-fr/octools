<?php

namespace Webid\Octools\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class UserCreateRequestSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('UserCreateRequest')
            ->properties(
                Schema::string('name')->example('demo'),
                Schema::string('email')->format('email'),
                Schema::string('password')->example('MyStrongPassword!'),
                Schema::boolean('isAdmin'),
                Schema::string('organization_name')->example('demo'),
            )
            ->required(
                'name',
                'email',
                'isAdmin',
                'organization_name'
            );
    }
}
