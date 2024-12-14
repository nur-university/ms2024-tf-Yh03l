<?php

declare(strict_types=1);

namespace Commercial\Domain\Aggregates\Catalog;

use Commercial\Domain\ValueObjects\ServiceCost;
use Commercial\Domain\Events\CatalogCreated;
use Commercial\Domain\Events\ServiceAdded;
use Commercial\Domain\Events\ServiceRemoved;

class Catalog
{
    private string $id;
    private array $services;
    private string $estado;
    private array $events = [];

    private function __construct(string $id, string $estado)
    {
        $this->id = $id;
        $this->services = [];
        $this->estado = $estado;
    }

    public static function create(string $id, string $estado): self
    {
        $catalog = new self($id, $estado);
        $catalog->addEvent(new CatalogCreated($id));
        return $catalog;
    }

    public function agregarServicio(Service $service): void
    {
        if ($this->hasService($service->getId())) {
            throw new \DomainException('El servicio ya existe en el catálogo');
        }

        $this->services[] = $service;
        $this->addEvent(new ServiceAdded($this->id, $service->getId()));
    }

    public function removerServicio(string $serviceId): void
    {
        if (!$this->hasService($serviceId)) {
            throw new \DomainException('El servicio no existe en el catálogo');
        }

        $this->services = array_filter(
            $this->services,
            fn($service) => $service->getId() !== $serviceId
        );

        $this->addEvent(new ServiceRemoved($this->id, $serviceId));
    }

    public function actualizarCatalogo(string $estado): void
    {
        $this->estado = $estado;
    }

    private function hasService(string $serviceId): bool
    {
        return !empty(array_filter(
            $this->services,
            fn($service) => $service->getId() === $serviceId
        ));
    }

    private function addEvent(object $event): void
    {
        $this->events[] = $event;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
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
        return array_map(function(Service $service) {
            return [
                'id' => $service->getId(),
                'nombre' => $service->getNombre(),
                'descripcion' => $service->getDescripcion(),
                'costo' => [
                    'monto' => $service->getCosto()->getMonto(),
                    'moneda' => $service->getCosto()->getMoneda(),
                    'vigencia' => $service->getCosto()->getVigencia()->format('Y-m-d')
                ],
                'tipo_servicio_id' => $service->getTipoServicioId(),
                'estado' => $service->getEstado()
            ];
        }, $this->services);
    }
} 