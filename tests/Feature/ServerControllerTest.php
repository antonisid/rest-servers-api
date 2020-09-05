<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Server;
use App\Transformers\ServerTransformer;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
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

        //Artisan::call('db:seed', ['--class' => 'ServerSeeder']);

        $user = factory(User::class)->create();

        $this->token = JWTAuth::fromUser($user);
    }

    /**
     * Test index()
     */
    public function testGetServers(): void
    {
        $server = factory(Server::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/assets');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'items' => [
                [
                    'id' => $server->getId(),
                    'model' => $server->getModel(),
                    'hdd' => [
                        'description' => $server->getHdd(),
                        'capacity' => $server->getHddCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'ram' => [
                        'description' => $server->getRam(),
                        'capacity' => $server->getRamCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'location' => $server->getLocation(),
                    'price' => $server->getPrice(),
                    'created_at' => $server->getCreatedAt(),
                    'updated_at' => $server->getUpdatedAt()
                ]
            ]
        ]);
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
                'hdd' => [
                    'description' => $server->getHdd(),
                    'capacity' => $server->getHddCapacity(),
                    'unit' => ServerTransformer::GB_UNIT
                ],
                'ram' => [
                    'description' => $server->getRam(),
                    'capacity' => $server->getRamCapacity(),
                    'unit' => ServerTransformer::GB_UNIT
                ],
                'location' => $server->getLocation(),
                'price' => $server->getPrice(),
                'created_at' => $server->getCreatedAt(),
                'updated_at' => $server->getUpdatedAt()
            ]
        ]);
    }
}
