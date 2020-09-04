<?php

use Illuminate\Database\Eloquent\Factory;
use App\Server;
use Faker\Generator as Faker;

/** @var Factory $factory */
$factory->define(Server::class, function (Faker $faker) {
    return [
        'model' => 'Dell R210Intel Xeon X3440',
        'hdd' => '2x2TBSATA2',
        'hdd_capacity' => 4000,
        'ram' => '16GBDDR3',
        'ram_capacity' => 16,
        'location' => 'AmsterdamAMS-01',
        'price' => '€49.99',
    ];
});
