<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Server;
use App\Transformers\ServerTransformer;
use App\User;
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
     * Test show() (/servers/1)
     */
    public function testShowServer(): void
    {
        /** @var Server $server */
        $server = factory(Server::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers/' . $server->getId());

        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
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

    /**
     * Test index() (/servers)
     */
    public function testGetServers(): void
    {
        $server = factory(Server::class)->create();
        $server2 = factory(Server::class)->create([
            'location' => 'RotterdamRot-01'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
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
                ],
                [
                    'id' => $server2->getId(),
                    'model' => $server2->getModel(),
                    'hdd' => [
                        'description' => $server2->getHdd(),
                        'capacity' => $server2->getHddCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'ram' => [
                        'description' => $server2->getRam(),
                        'capacity' => $server2->getRamCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'location' => $server2->getLocation(),
                    'price' => $server2->getPrice(),
                    'created_at' => $server2->getCreatedAt(),
                    'updated_at' => $server2->getUpdatedAt()
                ]
            ]
        ]);
    }

    /**
     * Test index() (/servers?location=AmsterdamAMS-01)
     */
    public function testGetServersByLocation(): void
    {
        $server = factory(Server::class)->create();

        $server2 = factory(Server::class)->create([
            'location' => 'RotterdamRot-01'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers?location=RotterdamRot-01');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
            'items' => [
                [
                    'id' => $server2->getId(),
                    'model' => $server2->getModel(),
                    'hdd' => [
                        'description' => $server2->getHdd(),
                        'capacity' => $server2->getHddCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'ram' => [
                        'description' => $server2->getRam(),
                        'capacity' => $server2->getRamCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'location' => $server2->getLocation(),
                    'price' => $server2->getPrice(),
                    'created_at' => $server2->getCreatedAt(),
                    'updated_at' => $server2->getUpdatedAt()
                ]
            ]
        ]);

        $response = $response->getOriginalContent();

        $this->assertCount(1, $response['items']);
    }

    /**
     * Test index() (/servers?storage[min]=1000&storage[max]=2000)
     */
    public function testGetServersByStorage(): void
    {
        $server = factory(Server::class)->create([
            'hdd_capacity' => 8000
        ]);

        $server2 = factory(Server::class)->create([
            'hdd_capacity' => 16000
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers?storage[min]=12000&storage[max]=24000');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
            'items' => [
                [
                    'id' => $server2->getId(),
                    'model' => $server2->getModel(),
                    'hdd' => [
                        'description' => $server2->getHdd(),
                        'capacity' => $server2->getHddCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'ram' => [
                        'description' => $server2->getRam(),
                        'capacity' => $server2->getRamCapacity(),
                        'unit' => ServerTransformer::GB_UNIT
                    ],
                    'location' => $server2->getLocation(),
                    'price' => $server2->getPrice(),
                    'created_at' => $server2->getCreatedAt(),
                    'updated_at' => $server2->getUpdatedAt()
                ]
            ]
        ]);

        $response = $response->getOriginalContent();

        $this->assertCount(1, $response['items']);
    }

    /**
     * Test index() (/servers?ram[]=8&ram[]=12)
     */
    public function testGetServersByRam(): void
    {
        $server = factory(Server::class)->create([
            'ram_capacity' => 8
        ]);

        $server2 = factory(Server::class)->create([
            'ram_capacity' => 16
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers?ram[]=8&ram[]=24&ram[]=32');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
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

        $response = $response->getOriginalContent();

        $this->assertCount(1, $response['items']);
    }
}
