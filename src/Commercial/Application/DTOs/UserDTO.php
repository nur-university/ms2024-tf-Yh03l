<?php

declare(strict_types=1);

namespace Commercial\Application\DTOs;

class UserDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $nombre,
        public readonly string $apellido,
        public readonly string $email,
        public readonly string $tipo_usuario_id,
        public readonly string $estado
    ) {
    }
} 