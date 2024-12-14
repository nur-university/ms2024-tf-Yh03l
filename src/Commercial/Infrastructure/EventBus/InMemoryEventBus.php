<?php

declare(strict_types=1);

namespace Commercial\Infrastructure\EventBus;

class InMemoryEventBus implements EventBus
{
    private array $handlers = [];

    public function publish(object $event): void
    {
        $eventClass = get_class($event);
        if (!isset($this->handlers[$eventClass])) {
            return;
        }

        foreach ($this->handlers[$eventClass] as $handler) {
            $handler($event);
        }
    }

    public function subscribe(string $eventClass, callable $handler): void
    {
        if (!isset($this->handlers[$eventClass])) {
            $this->handlers[$eventClass] = [];
        }

        $this->handlers[$eventClass][] = $handler;
    }
} 