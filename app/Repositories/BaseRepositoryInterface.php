<?php

namespace App\Repositories;

use App\Dtos\ServerDto;

interface BaseRepositoryInterface
{
    /**
     * @param int $id
     * @return ServerDto
     */
    public function get(int $id): ServerDto;

    /**
     * @param array $filters
     * @return array
     */
    public function getList(array $filters): array;
}
