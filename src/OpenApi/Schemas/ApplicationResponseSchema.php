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

class ApplicationResponseSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('ApplicationResponse')
            ->properties(
                Schema::object('data')->properties(
                    Schema::integer('id')->minimum(1),
                    Schema::string('name')->example('demo'),
                    Schema::string('token')
                        ->minLength(128)
                        ->maxLength(128)
                        ->example(
                            'C8e3yM2OabTabKFSJQKn20yz4ELWCNiUCbWNuUYZTehz1WMugx6C1jwGdHMO5yfO' .
                            '8cltCqT1DidhvYCmsHEiltAzPvibxhCL28MALTfbOK94Oka40xRmlkZh85zoDtgU'
                        ),
                    Schema::object('workspace')
                        ->properties(
                            Schema::integer('id')->minimum(1),
                            Schema::string('name')->example('demo'),
                        ),
                ),
            );
    }
}
