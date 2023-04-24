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

class WorkspaceResponseSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('WorkspaceResponse')
            ->properties(
                Schema::object('data')->properties(
                    Schema::integer('id')->minimum(1),
                    Schema::string('name')->example('demo'),
                    Schema::object('organization')
                        ->properties(
                            Schema::integer('id')->minimum(1),
                            Schema::string('name')->example('demo'),
                        ),
                    Schema::array('services')->items(WorkspaceServiceResponseSchema::ref()),
                    Schema::array('members')->items(
                        Schema::object()
                            ->properties(
                                Schema::integer('id')->minimum(1),
                                Schema::string('firstname')->example('John'),
                                Schema::string('lastname')->example('Doe'),
                                Schema::string('email')->format('email'),
                                Schema::string('birthdate')->format(Schema::FORMAT_DATE),
                            ),
                    ),
                ),
            );
    }
}
