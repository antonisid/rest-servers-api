<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Server;
use App\ServerFilter\ServerFilter;
use Tests\TestCase;

class ServerFilterTest extends TestCase
{
    /**
     * @param array $input
     * @param array $expected
     *
     * @dataProvider dataSet
     */
    public function testApplyFiltersFromRequest(array $input, array $expected): void
    {
        $query = ServerFilter::applyFilters($input, (new Server())->newQuery());

        $this->assertEquals($expected, $query->getBindings());
    }

    /**
     * @return array
     */
    public function dataSet(): array
    {
        return [
            [['location' => 'AmsterdamAMS-01'], ['AmsterdamAMS-01']],
            [['ram' => [8, 16]], [8, 16]],
            [['storage' => ['min' => 3000, 'max' => 4000]], [3000, 4000]],
            [['hard_disk_type' => 'ssd'], ['%ssd%']]
        ];
    }
}
