<?php

declare(strict_types=1);

namespace Commercial\Application\Queries\ListActiveServices;

final class ListActiveServicesQuery
{
    public function __construct(
        public readonly ?string $catalogId = null
    ) {}
}
