<?php

declare(strict_types=1);

namespace Commercial\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Commercial\Infrastructure\Persistence\Eloquent\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Commercial\Domain\ValueObjects\ServiceStatus;
use Commercial\Domain\ValueObjects\ServiceCost as ServiceCostVO;

class ServiceModel extends Model
{
    use HasUuid, SoftDeletes;

    protected $table = 'servicios';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'tipo_servicio_id',
        'estado',
        'catalogo_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function catalogo(): BelongsTo
    {
        return $this->belongsTo(CatalogModel::class, 'catalogo_id');
    }

    public function costos(): HasMany
    {
        return $this->hasMany(ServiceCostModel::class, 'servicio_id');
    }

    public function currentCost(): ?ServiceCostVO
    {
        // Primero intentamos obtener el costo vigente actual
        $currentCost = $this->costos()
            ->where('vigencia', '<=', now())
            ->orderBy('vigencia', 'desc')
            ->first();

        if ($currentCost) {
            return new ServiceCostVO(
                monto: $currentCost->monto,
                moneda: $currentCost->moneda,
                vigencia: new \DateTimeImmutable($currentCost->vigencia)
            );
        }

        // Si no hay costo vigente, buscamos el próximo costo programado
        $futureCost = $this->costos()
            ->where('vigencia', '>', now())
            ->orderBy('vigencia', 'asc')
            ->first();

        if ($futureCost) {
            return new ServiceCostVO(
                monto: $futureCost->monto,
                moneda: $futureCost->moneda,
                vigencia: new \DateTimeImmutable($futureCost->vigencia)
            );
        }

        // Si no hay costos, retornamos null
        return null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('estado', ServiceStatus::ACTIVO->toString());
    }

    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('estado', ServiceStatus::INACTIVO->toString());
    }

    public function scopeDiscontinued(Builder $query): Builder
    {
        return $query->where('estado', ServiceStatus::SUSPENDIDO->toString());
    }

    public function scopeByCatalog(Builder $query, string $catalogId): Builder
    {
        return $query->where('catalogo_id', $catalogId);
    }

    public function isActive(): bool
    {
        return $this->estado === ServiceStatus::ACTIVO->toString();
    }

    public function canBeModified(): bool
    {
        return $this->estado !== ServiceStatus::SUSPENDIDO->toString();
    }

    public function canUpdateCost(): bool
    {
        return $this->isActive();
    }
}
