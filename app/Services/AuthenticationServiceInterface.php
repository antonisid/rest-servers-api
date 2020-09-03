<?php

namespace App\Services;

interface AuthenticationServiceInterface
{
    /**
     * @param array $credentials
     * @return string
     */
    public function userLogin(array $credentials): string;

    /**
     * @param array $userInfo
     * @return string
     */
    public function userRegister(array $userInfo): string;
}
