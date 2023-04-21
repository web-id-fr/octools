<?php

namespace Webid\Octools\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use Webid\Octools\OpenApi\Schemas\ApplicationResponseSchema;

class ApplicationResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(ApplicationResponseSchema::ref())
        );
    }
}
