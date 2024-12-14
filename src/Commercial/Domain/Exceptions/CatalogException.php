<?php

declare(strict_types=1);

namespace Commercial\Domain\Exceptions;

class CatalogException extends \DomainException
{
    public static function notFound(string $id): self
    {
        return new self("Catálogo con ID {$id} no encontrado");
    }

    public static function serviceAlreadyExists(string $serviceId): self
    {
        return new self("El servicio con ID {$serviceId} ya existe en el catálogo");
    }

    public static function serviceNotFound(string $serviceId): self
    {
        return new self("El servicio con ID {$serviceId} no existe en el catálogo");
    }

    public static function invalidState(string $currentState): self
    {
        return new self("Estado inválido del catálogo: {$currentState}");
    }
} 