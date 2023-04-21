<?php

namespace Webid\Octools\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class DeletedResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Resource deleted response')
            ->content(
                MediaType::json()->schema(Schema::object()->properties(
                    Schema::string('success')
                        ->example('Resource deleted with success'),
                ))
            );
    }
}
