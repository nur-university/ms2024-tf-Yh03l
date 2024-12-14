<?php

declare(strict_types=1);

namespace Commercial\Application\Commands\UpdateServiceStatus;

use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Domain\Exceptions\CatalogException;

final class UpdateServiceStatusHandler
{
    public function __construct(
        private readonly CatalogRepository $catalogRepository
    ) {}

    public function handle(UpdateServiceStatusCommand $command): void
    {
        $service = $this->catalogRepository->findServiceById($command->serviceId);

        if (!$service) {
            throw CatalogException::serviceNotFound($command->serviceId);
        }

        if (!$service->canUpdateStatus($command->status)) {
            throw CatalogException::invalidStatusTransition($service->status, $command->status);
        }

        $service->updateStatus($command->status);

        $this->catalogRepository->save($service);
    }
}
