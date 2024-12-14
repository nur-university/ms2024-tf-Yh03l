<?php

declare(strict_types=1);

namespace Commercial\Application\Commands\UpdateService;

use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Domain\Exceptions\CatalogException;

final class UpdateServiceHandler
{
    public function __construct(
        private readonly CatalogRepository $catalogRepository
    ) {}

    public function handle(UpdateServiceCommand $command): void
    {
        $service = $this->catalogRepository->findServiceById($command->serviceId);

        if (!$service) {
            throw CatalogException::serviceNotFound($command->serviceId);
        }

        $service->update(
            name: $command->name,
            description: $command->description
        );

        if ($command->cost) {
            $service->updateCost($command->cost);
        }

        $this->catalogRepository->save($service);
    }
}
