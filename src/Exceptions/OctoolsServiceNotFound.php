<?php

declare(strict_types=1);

namespace Webid\Octools\Exceptions;

use Exception;

class OctoolsServiceNotFound extends Exception
{
    public static function fromName(string $serviceName): self
    {
        return new self(
            message: "Service '{$serviceName}' not found",
        );
    }
}
