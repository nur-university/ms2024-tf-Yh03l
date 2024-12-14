<?php

declare(strict_types=1);

namespace Commercial\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'costo' => ['required', 'numeric', 'min:0'],
            'moneda' => ['required', 'string', 'in:PEN,USD'],
            'vigencia' => ['required', 'date'],
            'tipo_servicio_id' => ['required', 'uuid', 'exists:tipos_servicio,id'],
            'catalogo_id' => ['required', 'uuid', 'exists:catalogos,id'],
        ];
    }
} 