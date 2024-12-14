<?php

declare(strict_types=1);

namespace Commercial\Application\Commands\CreateCatalog;

class CreateCatalogCommand
{
    private string $estado;

    public function __construct(string $estado)
    {
        $this->estado = $estado;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }
} 