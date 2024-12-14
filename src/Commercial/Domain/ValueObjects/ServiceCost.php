<?php

declare(strict_types=1);

namespace Commercial\Domain\ValueObjects;

class ServiceCost
{
    private float $monto;
    private string $moneda;
    private \DateTimeImmutable $vigencia;

    public function __construct(float $monto, string $moneda, \DateTimeImmutable $vigencia)
    {
        $this->validateMonto($monto);
        $this->validateMoneda($moneda);
        $this->validateVigencia($vigencia);

        $this->monto = $monto;
        $this->moneda = $moneda;
        $this->vigencia = $vigencia;
    }

    private function validateMonto(float $monto): void
    {
        if ($monto <= 0) {
            throw new \InvalidArgumentException('El monto debe ser mayor que cero');
        }
    }

    private function validateMoneda(string $moneda): void
    {
        $monedasValidas = ['PEN', 'USD'];
        if (!in_array($moneda, $monedasValidas)) {
            throw new \InvalidArgumentException('Moneda no válida');
        }
    }

    private function validateVigencia(\DateTimeImmutable $vigencia): void
    {
        if ($vigencia < new \DateTimeImmutable()) {
            throw new \InvalidArgumentException('La vigencia no puede ser una fecha pasada');
        }
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function getMoneda(): string
    {
        return $this->moneda;
    }

    public function getVigencia(): \DateTimeImmutable
    {
        return $this->vigencia;
    }

    public function equals(ServiceCost $other): bool
    {
        return $this->monto === $other->monto &&
               $this->moneda === $other->moneda &&
               $this->vigencia == $other->vigencia;
    }
} 