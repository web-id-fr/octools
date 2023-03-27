<?php

declare(strict_types=1);

namespace Webid\Octools\Shared;

class CursorPaginator
{
    public function __construct(
        public readonly int $perPage,
        public array $items,
        public readonly ?int $total = null,
        public readonly ?string $cursor = null,
    ) {
    }
}
