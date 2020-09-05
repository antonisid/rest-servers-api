<?php

namespace App\Services;

interface ServerServiceInterface
{
    /**
     * @param int $id
     * @return array
     */
    public function getServer(int $id): array;

    /**
     * @param array $filters
     * @return array
     */
    public function getServers(array $filters): array;
}
