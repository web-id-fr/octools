<?php

namespace Webid\Octools\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use Webid\Octools\OpenApi\Schemas\ApplicationUpdateRequestSchema;

class UpdateApplicationRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('ApplicationUpdate')
            ->description('Application data')
            ->content(
                MediaType::json()->schema(ApplicationUpdateRequestSchema::ref())
            );
    }
}
