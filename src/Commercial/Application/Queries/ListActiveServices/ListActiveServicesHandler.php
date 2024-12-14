<?php

declare(strict_types=1);

namespace Commercial\Application\Queries\ListActiveServices;

use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Domain\ValueObjects\ServiceStatus;
use Commercial\Application\DTOs\ServiceDTO;

final class ListActiveServicesHandler
{
    public function __construct(
        private readonly CatalogRepository $catalogRepository
    ) {}

    /**
     * @return ServiceDTO[]
     */
    public function handle(ListActiveServicesQuery $query): array
    {
        $services = $this->catalogRepository->findServicesByStatus(
            status: ServiceStatus::ACTIVE,
            catalogId: $query->catalogId
        );

        return array_map(
            fn($service) => ServiceDTO::fromEntity($service),
            $services
        );
    }
}
