<?php

declare(strict_types=1);

namespace Commercial\Application\DTOs;

use Commercial\Domain\Aggregates\Catalog\Service;
use Commercial\Domain\ValueObjects\ServiceStatus;
use Commercial\Domain\ValueObjects\ServiceCost;

final class ServiceDTO
{
    private function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
        public readonly ServiceStatus $status,
        public readonly ServiceCost $cost,
        public readonly string $catalogId
    ) {}

    public static function fromEntity(Service $service): self
    {
        return new self(
            id: $service->id,
            name: $service->name,
            description: $service->description,
            status: $service->status,
            cost: $service->cost,
            catalogId: $service->catalogId
        );
    }
}
