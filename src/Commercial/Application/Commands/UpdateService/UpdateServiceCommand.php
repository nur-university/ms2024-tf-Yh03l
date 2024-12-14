<?php

declare(strict_types=1);

namespace Commercial\Application\Commands\UpdateService;

use Commercial\Domain\ValueObjects\ServiceCost;

final class UpdateServiceCommand
{
    public function __construct(
        public readonly string $serviceId,
        public readonly string $name,
        public readonly string $description,
        public readonly ?ServiceCost $cost = null
    ) {}
}
