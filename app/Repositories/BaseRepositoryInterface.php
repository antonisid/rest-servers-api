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
}
