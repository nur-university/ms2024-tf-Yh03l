<?php

declare(strict_types=1);

namespace Commercial\Application\Queries\GetCatalog;

class GetCatalogQuery
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
} 