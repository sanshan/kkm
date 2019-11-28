<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\KKM;
use Faker\Generator as Faker;

$factory->define(KKM::class, function (Faker $faker) {
    return [
        'factory_number' => $faker->unique()->numberBetween(1000000000, 9999999999),
        'serial_number'  => $faker->unique()->numberBetween(10000000, 99999999),
        'gas_station_id' => $faker->numberBetween(1, 500),
        'region_id'      => $faker->numberBetween(1, 100),
    ];
});
