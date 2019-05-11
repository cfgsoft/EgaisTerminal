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

$factory->define(App\Models\Order\Order::class, function (Faker $faker) {
    return [
        'date' => Carbon::create('2018', '11', '24'),
        'number' => str_random(10),
        'barcode' => str_random(10),
        'status' => '0',
        'quantity' => '0',
        'quantity_mark' => '0',
        'doc_type' => '1',
        'doc_id' => str_random(36)
    ];
});

//$factory->define(App\Models\Order\OrderErrorLine::class, function (Faker $faker) {
//    return [
//        'order_id' => '9',
//        'markcode' => str_random(150),
//        'message' => 'Журнал ошибок ' . str_random(150)
//    ];
//});

$factory->define(App\Models\ReturnedInvoice\ReturnedInvoice::class, function (Faker $faker) {
    return [
        'date' => Carbon::create('2018', '12', '24'),
        'number' => str_random(10),
        'barcode' => str_random(10),
        'status' => '0',
        'quantity' => '0',
        'quantity_marks' => '0',
        'doc_type' => '3',
        'doc_id' => str_random(36)
    ];
});

$factory->define(App\Models\Invoice\Invoice::class, function (Faker $faker) {
    return [
        'date' => Carbon::create('2019', '01', '24'),
        'number' => str_random(11),
        'barcode' => str_random(12),
        'doc_type' => '3',
        'doc_id' => str_random(36)
    ];
});

$factory->define(App\Models\Inventory\Inventory::class, function (Faker $faker) {
    return [
        'date' => Carbon::create('2019', '05', '10'),
        'number' => str_random(11),
        'department_id' => 1
    ];
});