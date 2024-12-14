<?php

declare(strict_types=1);

namespace Commercial\Application\Commands\CreateCatalog;

use Commercial\Domain\Aggregates\Catalog\Catalog;
use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Infrastructure\EventBus\EventBus;
use Illuminate\Support\Str;

class CreateCatalogHandler
{
    private CatalogRepository $repository;
    private EventBus $eventBus;

    public function __construct(CatalogRepository $repository, EventBus $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateCatalogCommand $command): void
    {
        $catalog = Catalog::create(
            (string) Str::uuid(),
            $command->getEstado()
        );

        $this->repository->save($catalog);

        // Publicar eventos
        foreach ($catalog->getEvents() as $event) {
            $this->eventBus->publish($event);
        }

        $catalog->clearEvents();
    }
} 