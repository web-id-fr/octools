<?php

declare(strict_types=1);

namespace Webid\Octools;

class OctoolsService
{
    private function __construct(
        public readonly string $name,
        public readonly string $memberKey,
        public readonly array $connectionConfig,
    ) {
    }

    public static function make(string $name, string $memberKey, array $connectionConfig): OctoolsService
    {
        return new self($name, $memberKey, $connectionConfig);
    }

    public function name(): string
    {
        return $this->name;
    }
}
