<?php

namespace Tests\Feature;

use App\Server;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ServerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    private $token;

    public function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->token = JWTAuth::fromUser($user);
    }

    /**
     * Test show()
     */
    public function testShowServer(): void
    {
        /** @var Server $server */
        $server = factory(Server::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers/' . $server->getId());

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'items' => [
                'id' => $server->getId(),
                'model' => $server->getModel(),
                'hdd' => $server->getHdd(),
                'hdd_capacity' => $server->getHddCapacity(),
                'ram' => $server->getRam(),
                'ram_capacity' => $server->getRamCapacity(),
                'location' => $server->getLocation(),
                'price' => $server->getPrice(),
                'created_at' => $server->getCreatedAt(),
                'updated_at' => $server->getUpdatedAt()
            ]
        ]);
    }
}
