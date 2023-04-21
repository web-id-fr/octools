<?php

namespace Webid\Octools\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use Webid\Octools\OpenApi\Schemas\MemberCreateRequestSchema;

class StoreMemberRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('MemberCreate')
            ->description('Member data')
            ->content(
                MediaType::json()->schema(MemberCreateRequestSchema::ref())
            );
    }
}
