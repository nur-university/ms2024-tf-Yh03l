<?php

declare(strict_types=1);

namespace Commercial\Api\Controllers;

use Commercial\Api\Requests\AddServiceRequest;
use Commercial\Api\Requests\CreateCatalogRequest;
use Commercial\Application\Commands\CreateCatalog\CreateCatalogCommand;
use Commercial\Application\Commands\AddService\AddServiceCommand;
use Commercial\Application\Commands\RemoveService\RemoveServiceCommand;
use Commercial\Application\Queries\GetCatalog\GetCatalogQuery;
use Commercial\Application\Queries\ListCatalogs\ListCatalogsQuery;
use Commercial\Domain\Exceptions\CatalogException;
use Commercial\Infrastructure\Bus\CommandBus;
use Commercial\Infrastructure\Bus\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CatalogController extends Controller
{
    private CommandBus $commandBus;
    private QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function create(CreateCatalogRequest $request): JsonResponse
    {
        $command = new CreateCatalogCommand(
            $request->getEstado()
        );

        try {
            $this->commandBus->dispatch($command);
            return new JsonResponse(['message' => 'Catálogo creado exitosamente'], Response::HTTP_CREATED);
        } catch (CatalogException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function get(string $id): JsonResponse
    {
        $query = new GetCatalogQuery($id);

        try {
            $catalog = $this->queryBus->ask($query);
            if ($catalog === null) {
                return new JsonResponse(['error' => 'Catálogo no encontrado'], Response::HTTP_NOT_FOUND);
            }
            return new JsonResponse($catalog->toArray(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function list(): JsonResponse
    {
        $query = new ListCatalogsQuery();

        try {
            $catalogs = $this->queryBus->ask($query);
            return new JsonResponse(
                array_map(fn($catalog) => $catalog->toArray(), $catalogs),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addService(string $catalogId, AddServiceRequest $request): JsonResponse
    {
        $command = new AddServiceCommand(
            $catalogId,
            $request->getNombre(),
            $request->getDescripcion(),
            $request->getCosto(),
            $request->getMoneda(),
            $request->getVigencia(),
            $request->getTipoServicioId()
        );

        try {
            $this->commandBus->dispatch($command);
            return new JsonResponse(['message' => 'Servicio agregado exitosamente'], Response::HTTP_OK);
        } catch (CatalogException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function removeService(string $catalogId, string $serviceId): JsonResponse
    {
        $command = new RemoveServiceCommand($catalogId, $serviceId);

        try {
            $this->commandBus->dispatch($command);
            return new JsonResponse(['message' => 'Servicio removido exitosamente'], Response::HTTP_OK);
        } catch (CatalogException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
} 