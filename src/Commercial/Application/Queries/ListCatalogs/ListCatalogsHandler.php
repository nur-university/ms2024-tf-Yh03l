<?php

declare(strict_types=1);

namespace Commercial\Application\Queries\ListCatalogs;

use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Application\DTOs\CatalogDTO;

class ListCatalogsHandler
{
    private CatalogRepository $repository;

    public function __construct(CatalogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ListCatalogsQuery $query): array
    {
        $catalogs = $this->repository->findAll();

        return array_map(function ($catalog) {
            return new CatalogDTO(
                $catalog->getId(),
                $catalog->getEstado(),
                $catalog->getServices()
            );
        }, $catalogs);
    }
} 