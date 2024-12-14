<?php

declare(strict_types=1);

namespace Commercial\Domain\Repositories;

use Commercial\Domain\Aggregates\User\User;

interface UserRepository
{
    public function findById(string $id): ?User;
    public function findByEmail(string $email): ?User;
    public function save(User $user): void;
    public function delete(string $id): void;
    public function findAll(): array;
} 