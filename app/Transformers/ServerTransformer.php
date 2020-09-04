<?php
declare(strict_types=1);

namespace App\Transformers;

use App\Dtos\ServerDto;

class ServerTransformer
{
    /**
     * @var string
     */
    public const GB_UNIT = 'GB';

    /**
     * @param ServerDto $serverDto
     * @return array
     */
    public function transform(ServerDto $serverDto): array
    {
        return [
            'id' => $serverDto->getId(),
            'model' => $serverDto->getModel(),
            'hdd' => [
                'description' => $serverDto->getHdd(),
                'capacity' => $serverDto->getHddCapacity(),
                'unit' => self::GB_UNIT
            ],
            'ram' => [
                'description' => $serverDto->getRam(),
                'capacity' => $serverDto->getRamCapacity(),
                'unit' => self::GB_UNIT
            ],
            'location' => $serverDto->getLocation(),
            'price' => $serverDto->getPrice(),
            'created_at' => $serverDto->getUpdatedAt(),
            'updated_at' => $serverDto->getUpdatedAt(),
        ];
    }
}
