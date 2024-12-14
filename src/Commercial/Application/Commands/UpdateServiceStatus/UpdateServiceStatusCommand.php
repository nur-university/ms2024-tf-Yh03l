<?php

declare(strict_types=1);

namespace Commercial\Application\Commands\UpdateServiceStatus;

use Commercial\Domain\ValueObjects\ServiceStatus;

final class UpdateServiceStatusCommand
{
    public function __construct(
        public readonly string $serviceId,
        public readonly ServiceStatus $status
    ) {}
}
