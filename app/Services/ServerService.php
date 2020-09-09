<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\ServerRepositoryInterface;
use App\Transformers\ServerTransformer;

class ServerService implements ServerServiceInterface
{
    /**
     * @var ServerRepositoryInterface
     */
    private $serverRepository;

    /**
     * @var ServerTransformer
     */
    private $serverTransformer;

    public function __construct(ServerRepositoryInterface $serverRepository, ServerTransformer $serverTransformer)
    {
        $this->serverRepository = $serverRepository;
        $this->serverTransformer = $serverTransformer;
    }

    /**
     * @inheritDoc
     */
    public function getServers(array $filters): array
    {
        $serverDtos = $this->serverRepository->getList($filters);

        return $this->serverTransformer->transformList(...$serverDtos);
    }

    /**
     * @inheritDoc
     */
    public function getServer(int $id): array
    {
        $serverDto = $this->serverRepository->get($id);

        return $this->serverTransformer->transform($serverDto);
    }
}
