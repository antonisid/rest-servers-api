<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Dtos\ServerDto;
use App\Server;

class ServerRepository implements ServerRepositoryInterface
{
    /**
     * @var Server
     */
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ServerDto
    {
        return $this->createDto($this->findById($id));
    }

    /**
     * @param int $id
     * @return Server
     */
    private function findById(int $id): Server
    {
        return $this->server->findOrFail($id);
    }

    /**
     * @param Server $server
     * @return ServerDto
     */
    private function createDto(Server $server): ServerDto
    {
        return (new ServerDto())
            ->setId($server->getId())
            ->setModel($server->getModel())
            ->setHdd($server->getHdd())
            ->setHddCapacity($server->getHddCapacity())
            ->setRam($server->getRam())
            ->setRamCapacity($server->getRamCapacity())
            ->setLocation($server->getLocation())
            ->setPrice($server->getPrice())
            ->setCreatedAt($server->getCreatedAt())
            ->setUpdatedAt($server->getUpdatedAt());
    }
}
