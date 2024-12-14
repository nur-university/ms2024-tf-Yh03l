<?php

declare(strict_types=1);

namespace Commercial\Application\Queries\GetUserByEmail;

use Commercial\Domain\Repositories\UserRepository;
use Commercial\Application\DTOs\UserDTO;

class GetUserByEmailHandler
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetUserByEmailQuery $query): ?UserDTO
    {
        return $this->handle($query);
    }

    public function handle(GetUserByEmailQuery $query): ?UserDTO
    {
        $user = $this->repository->findByEmail($query->getEmail());

        if ($user === null) {
            return null;
        }

        return new UserDTO(
            $user->getId(),
            $user->getNombre(),
            $user->getApellido(),
            $user->getEmail()->getValue(),
            $user->getTipoUsuarioId(),
            $user->getEstado()
        );
    }
} 