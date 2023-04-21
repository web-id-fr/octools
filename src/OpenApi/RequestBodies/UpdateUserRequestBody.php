<?php

namespace Webid\Octools\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use Webid\Octools\OpenApi\Schemas\UserUpdateRequestSchema;

class UpdateUserRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('UserUpdate')
            ->description('User data')
            ->content(
                MediaType::json()->schema(UserUpdateRequestSchema::ref())
            );
    }
}
