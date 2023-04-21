<?php

namespace Webid\Octools\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use Webid\Octools\OpenApi\Schemas\MemberUpdateRequestSchema;

class UpdateMemberRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('MemberUpdate')
            ->description('Member data')
            ->content(
                MediaType::json()->schema(MemberUpdateRequestSchema::ref())
            );
    }
}
