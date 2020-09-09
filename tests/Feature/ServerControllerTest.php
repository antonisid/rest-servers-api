<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Server;
use App\Transformers\ServerTransformer;
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
     * Test show() with wrong id (/servers/1234)
     */
    public function testShowServerReturnsHttpNotFound(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers/1234');

        $response->assertStatus(Response::HTTP_NOT_FOUND);
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

    /**
     * Test index() (/servers?hard_disk_type=sata)
     */
    public function testGetServersByHardDiskType(): void
    {
        $server = factory(Server::class)->create();

        $server2 = factory(Server::class)->create([
            'hdd' => '4x480GBSSD'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers?hard_disk_type=sata');

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

    /**
     * Test index() (/servers?hard_disk_type=sata)
     */
    public function testGetServersWithAllFiltersApplied(): void
    {
        $server = factory(Server::class)->create();

        $server2 = factory(Server::class)->create([
            'location' => 'RotterdamRot-01'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers?hard_disk_type=sata&location=RotterdamRot-01&ram[]=16&storage[min]=3000&storage[max]=8000');

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

    public function testSendRequestWithWrongToken(): void
    {
        /** @var Server $server */
        $server = factory(Server::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer wrong_token',
        ])->json('GET', '/api/servers/' . $server->getId());

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testSendRequestWithoutToken(): void
    {
        /** @var Server $server */
        $server = factory(Server::class)->create();

        $response = $this->json('GET', '/api/servers/' . $server->getId());

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Test index() (/api/servers?hard_disk_type=saadta&location=RotterdamRot-01&ram=1&storage[min]=100&storage[max]=350)
     */
    public function testCannotGetServersWhenRequestValidationFails(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers?hard_disk_type=saadta&location=RotterdamRot-01&ram=1&storage[min]=100&storage[max]=350');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson(
            [
                'error' => [
                    'storage' => [
                        'The selected storage is invalid.'
                    ],
                    'ram' => [
                        'The ram must be an array.',
                        'The selected ram is invalid.'
                    ],
                    'hard_disk_type' => [
                        'The selected hard disk type is invalid.'
                    ]
                ]
            ]
        );
    }

    /**
     * Test index() (/api/servers?storage[]=100&storage[mx]=350)
     */
    public function testCannotGetServersWithStorageWhenMinMaxMissing(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->json('GET', '/api/servers?storage[]=100&storage[mx]=350');

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson(
            [
                'error' => [
                    'storage.min' => [
                        'The storage.min field is required when storage is present.'
                    ],
                    'storage.max' => [
                        'The storage.max field is required when storage is present.',
                    ],
                ]
            ]
        );
    }
}
