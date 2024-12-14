<?php

declare(strict_types=1);

namespace Commercial\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CatalogModel extends Model
{
    use HasUuids;

    protected $table = 'catalogs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'estado'
    ];

    protected $casts = [
        'services' => 'array'
    ];
}