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

class MemberResponseSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('MemberResponse')
            ->properties(
                Schema::integer('id')->minimum(1),
                Schema::string('firstname')->example('John'),
                Schema::string('lastname')->example('Doe'),
                Schema::string('email')->format('email'),
                Schema::string('birthdate')->format('date'),
                WorkspaceResponseSchema::ref('workspace'),
                Schema::object('services')->example([
                    'github' => 'johndoe',
                    'gryzzly' => 'johndoe',
                    'slack' => 'johndoe'
                ]),
            );
    }
}
