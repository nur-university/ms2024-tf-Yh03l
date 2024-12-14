<?php

declare(strict_types=1);

namespace Commercial\Domain\Aggregates\User;

use Commercial\Domain\Events\UserCreated;
use Commercial\Domain\Events\UserUpdated;
use Commercial\Domain\ValueObjects\Email;

class User
{
    private string $id;
    private string $nombre;
    private string $apellido;
    private Email $email;
    private string $tipo_usuario_id;
    private string $estado;
    private array $events = [];

    private function __construct(
        string $id,
        string $nombre,
        string $apellido,
        Email $email,
        string $tipo_usuario_id,
        string $estado
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->tipo_usuario_id = $tipo_usuario_id;
        $this->estado = $estado;
    }

    public static function create(
        string $id,
        string $nombre,
        string $apellido,
        Email $email,
        string $tipo_usuario_id
    ): self {
        $user = new self(
            $id,
            $nombre,
            $apellido,
            $email,
            $tipo_usuario_id,
            'ACTIVO'
        );

        $user->addEvent(new UserCreated($id, $email->getValue()));
        return $user;
    }

    public function actualizarDatos(
        string $nombre,
        string $apellido,
        Email $email
    ): void {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;

        $this->addEvent(new UserUpdated($this->id));
    }

    public function validarCredenciales(): bool
    {
        // Aquí iría la lógica de validación de credenciales
        return true;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getTipoUsuarioId(): string
    {
        return $this->tipo_usuario_id;
    }

    public function getEstado(): string
    {
        return $this->estado;
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
} 