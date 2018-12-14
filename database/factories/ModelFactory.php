<?php

use Faker\Generator as Faker;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'date' => Carbon::create('2018', '11', '24'),
        'number' => str_random(10),
        'barcode' => str_random(10),
        'status' => '0',
        'Quantity' => '0',
        'QuantityMarks' => '0',
        'DocType' => '1',
        'DocId' => str_random(36)
    ];
});
