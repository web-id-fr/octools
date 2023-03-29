<?php

declare(strict_types=1);

namespace Webid\Octools;

class OctoolsService
{
    protected function __construct(
        public readonly string $name,
        public readonly string $memberKey,
        public readonly array $connectionConfig,
    ) {
    }
}
