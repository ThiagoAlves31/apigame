<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Fighter;
use Faker\Generator as Faker;

$factory->define(Fighter::class, function (Faker $faker) {
    $specieType = rand(0,1);
    return [
        'name' => $faker->name,
        'specie'  => $specieType ? 'Human' : 'Orc',
        'life'    => $specieType ? 12 : 20,
        'force'   => $specieType ? 1 : 2,
        'agility' => $specieType ? 2 : 0,
        //'weapon_id' => $specieType ? 1 : 2,
    ];
});
