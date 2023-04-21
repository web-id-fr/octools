<?php

namespace Webid\Octools\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ErrorNotFoundResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        return Response::notFound('ErrorNotFound')
            ->description('Not found error')
            ->content(
                MediaType::json()->schema(Schema::object()->properties(
                    Schema::string('message')
                        ->example('Resource not found.'),
                ))
            );
    }
}
