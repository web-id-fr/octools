<?php

namespace Webid\Octools\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CreatedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::created()
            ->description('Resource created response')
            ->content(
                MediaType::json()->schema(Schema::object()->properties(
                    Schema::string('success')
                        ->example('Resource created with success'),
                ))
        );
    }
}
