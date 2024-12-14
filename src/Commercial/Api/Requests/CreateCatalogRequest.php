<?php

declare(strict_types=1);

namespace Commercial\Api\Requests;

use Illuminate\Http\Request;

class CreateCatalogRequest extends Request
{
    private string $estado = 'activo';

    public function rules(): array
    {
        return [
            'estado' => 'string|in:activo,inactivo'
        ];
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('estado')) {
            $this->estado = $this->input('estado');
        }
    }
} 