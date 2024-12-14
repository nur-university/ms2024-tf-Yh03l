<?php

declare(strict_types=1);

namespace Commercial\Infrastructure\EventBus;

interface EventBus
{
    public function publish(object $event): void;
    public function subscribe(string $eventClass, callable $handler): void;
} 