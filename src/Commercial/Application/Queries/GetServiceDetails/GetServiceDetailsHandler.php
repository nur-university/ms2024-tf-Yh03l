declare(strict_types=1);

namespace Commercial\Application\Queries\GetServiceDetails;

use Commercial\Domain\Repositories\CatalogRepository;
use Commercial\Domain\Exceptions\CatalogException;
use Commercial\Application\DTOs\ServiceDTO;

final class GetServiceDetailsHandler
{
    public function __construct(
        private readonly CatalogRepository $catalogRepository
    ) {}

    public function handle(GetServiceDetailsQuery $query): ServiceDTO
    {
        $service = $this->catalogRepository->findServiceById($query->serviceId);

        if (!$service) {
            throw CatalogException::serviceNotFound($query->serviceId);
        }

        return ServiceDTO::fromEntity($service);
    }
} 