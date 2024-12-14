<?php

declare(strict_types=1);

namespace Commercial\Infrastructure\Providers;

use Commercial\Domain\Repositories\ContractRepository;
use Commercial\Domain\Repositories\UserRepository;
use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Infrastructure\Persistence\Eloquent\EloquentContractRepository;
use Commercial\Infrastructure\Persistence\Eloquent\EloquentUserRepository;
use Commercial\Infrastructure\Persistence\Eloquent\EloquentCatalogRepository;
use Commercial\Infrastructure\EventBus\EventBus;
use Commercial\Infrastructure\EventBus\InMemoryEventBus;
use Commercial\Infrastructure\Bus\CommandBus;
use Commercial\Infrastructure\Bus\QueryBus;
use Commercial\Infrastructure\Bus\LaravelCommandBus;
use Commercial\Infrastructure\Bus\LaravelQueryBus;
use Illuminate\Support\ServiceProvider;

class CommercialServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositories
        $this->app->bind(ContractRepository::class, EloquentContractRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(CatalogRepository::class, EloquentCatalogRepository::class);

        // Event Bus
        $this->app->singleton(EventBus::class, InMemoryEventBus::class);

        // Command & Query Buses
        $this->app->bind(LaravelCommandBus::class, function ($app) {
            return new LaravelCommandBus($app);
        });

        $this->app->bind(LaravelQueryBus::class, function ($app) {
            return new LaravelQueryBus($app);
        });

        $this->app->bind(CommandBus::class, LaravelCommandBus::class);
        $this->app->bind(QueryBus::class, LaravelQueryBus::class);
    }

    public function boot(): void
    {
        // Registrar las migraciones
        $this->loadMigrationsFrom([
            __DIR__.'/../Persistence/Migrations'
        ]);

        // Publicar las migraciones si es necesario
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Persistence/Migrations' => database_path('migrations'),
            ], 'commercial-migrations');
        }
    }
} 