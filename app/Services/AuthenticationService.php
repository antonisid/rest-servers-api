<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationService implements AuthenticationServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function userLogin(array $credentials): string
    {
        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            throw new UnauthorizedHttpException('Basic', 'Invalid credentials');
        }

        return $token;
    }

    /**
     * @inheritDoc
     */
    public function userRegister(array $userInfo): string
    {
        $user = $this->userRepository->create($userInfo['name'], $userInfo['email'], $userInfo['password']);

        return JWTAuth::fromUser($user);
    }
}
