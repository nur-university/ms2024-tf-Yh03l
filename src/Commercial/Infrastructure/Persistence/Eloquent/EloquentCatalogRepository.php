<?php

declare(strict_types=1);

namespace Commercial\Infrastructure\Persistence\Eloquent;

use Commercial\Domain\Aggregates\Catalog\Catalog;
use Commercial\Domain\Aggregates\Catalog\Service;
use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Domain\ValueObjects\ServiceCost;

class EloquentCatalogRepository implements CatalogRepository
{
    private CatalogModel $model;

    public function __construct(CatalogModel $model)
    {
        $this->model = $model;
    }

    public function findById(string $id): ?Catalog
    {
        $catalogModel = $this->model->find($id);
        if (!$catalogModel) {
            return null;
        }

        return $this->toDomain($catalogModel);
    }

    public function save(Catalog $catalog): void
    {
        $this->model->updateOrCreate(
            ['id' => $catalog->getId()],
            [
                'estado' => $catalog->getEstado(),
                'services' => $catalog->getServices()
            ]
        );
    }

    public function delete(string $id): void
    {
        $this->model->destroy($id);
    }

    public function findAll(): array
    {
        return $this->model
            ->all()
            ->map(fn($model) => $this->toDomain($model))
            ->all();
    }

    private function toDomain(CatalogModel $model): Catalog
    {
        $catalog = Catalog::create(
            $model->id,
            $model->estado
        );

        if (!empty($model->services)) {
            foreach ($model->services as $serviceData) {
                $service = new Service(
                    $serviceData['id'],
                    $serviceData['nombre'],
                    $serviceData['descripcion'],
                    new ServiceCost(
                        $serviceData['costo']['monto'],
                        $serviceData['costo']['moneda'],
                        new \DateTimeImmutable($serviceData['costo']['vigencia'])
                    ),
                    $serviceData['tipo_servicio_id'],
                    $serviceData['estado']
                );
                $catalog->agregarServicio($service);
            }
        }

        return $catalog;
    }
} 