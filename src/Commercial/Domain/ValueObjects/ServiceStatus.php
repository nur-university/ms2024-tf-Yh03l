<?php

declare(strict_types=1);

namespace Commercial\Domain\ValueObjects;

enum ServiceStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DISCONTINUED = 'discontinued';

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function canBeModified(): bool
    {
        return $this !== self::DISCONTINUED;
    }

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Activo',
            self::INACTIVE => 'Inactivo',
            self::DISCONTINUED => 'Descontinuado'
        };
    }

    public static function fromString(string $status): self
    {
        return match ($status) {
            'active', 'activo' => self::ACTIVE,
            'inactive', 'inactivo' => self::INACTIVE,
            'discontinued', 'descontinuado' => self::DISCONTINUED,
            default => throw new \InvalidArgumentException("Estado de servicio inválido: {$status}")
        };
    }
}
