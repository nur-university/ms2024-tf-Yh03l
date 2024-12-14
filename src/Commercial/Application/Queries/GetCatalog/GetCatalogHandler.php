<?php

declare(strict_types=1);

namespace Commercial\Application\Queries\GetCatalog;

use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Application\DTOs\CatalogDTO;

class GetCatalogHandler
{
    private CatalogRepository $repository;

    public function __construct(CatalogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetCatalogQuery $query): ?CatalogDTO
    {
        $catalog = $this->repository->findById($query->getId());

        if (!$catalog) {
            return null;
        }

        return new CatalogDTO(
            $catalog->getId(),
            $catalog->getEstado(),
            $catalog->getServices()
        );
    }
} 