<?php

declare(strict_types=1);

namespace Commercial\Domain\Aggregates\Catalog;

use Commercial\Domain\ValueObjects\ServiceCost;

class Service
{
    private string $id;
    private string $nombre;
    private string $descripcion;
    private ServiceCost $costo;
    private string $tipo_servicio_id;
    private string $estado;

    public function __construct(
        string $id,
        string $nombre,
        string $descripcion,
        ServiceCost $costo,
        string $tipo_servicio_id,
        string $estado
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->costo = $costo;
        $this->tipo_servicio_id = $tipo_servicio_id;
        $this->estado = $estado;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getCosto(): ServiceCost
    {
        return $this->costo;
    }

    public function getTipoServicioId(): string
    {
        return $this->tipo_servicio_id;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function actualizarEstado(string $estado): void
    {
        $this->estado = $estado;
    }
} 