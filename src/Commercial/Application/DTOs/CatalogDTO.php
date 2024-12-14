<?php

declare(strict_types=1);

namespace Commercial\Application\DTOs;

class CatalogDTO
{
    private string $id;
    private string $estado;
    private array $services;

    public function __construct(string $id, string $estado, array $services)
    {
        $this->id = $id;
        $this->estado = $estado;
        $this->services = $services;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
            'services' => $this->services
        ];
    }
} 