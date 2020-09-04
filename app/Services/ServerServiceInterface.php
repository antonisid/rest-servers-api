<?php

namespace App\Services;

interface ServerServiceInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getServer(int $id): array;
}
