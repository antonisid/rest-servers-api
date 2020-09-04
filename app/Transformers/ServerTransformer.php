<?php
declare(strict_types=1);

namespace App\Transformers;

use App\Dtos\ServerDto;

class ServerTransformer
{
    /**
     * @param ServerDto $serverDto
     * @return array
     */
    public function transform(ServerDto $serverDto): array
    {
        return [
            'id' => $serverDto->getId(),
            'model' => $serverDto->getModel(),
            'hdd' => $serverDto->getHdd(),
            'hdd_capacity' => $serverDto->getHddCapacity(),
            'ram' => $serverDto->getRam(),
            'ram_capacity' => $serverDto->getRamCapacity(),
            'location' => $serverDto->getLocation(),
            'price' => $serverDto->getPrice(),
            'created_at' => $serverDto->getUpdatedAt(),
            'updated_at' => $serverDto->getUpdatedAt(),
        ];
    }
}
