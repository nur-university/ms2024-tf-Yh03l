<?php

declare(strict_types=1);

namespace Commercial\Application\Queries\GetUserByEmail;

class GetUserByEmailQuery
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
} 