<?php

use Illuminate\Database\Seeder;

class WeaponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weapons')->insert(
            [
                [
                    'description' => 'Espada Longa',
                    'attack' => 2,
                    'defense' => 1,
                    'dice' => 6,
                    'fighter_id' => DB::table('fighters')
                        ->where('specie', 'Human')
                        ->pluck('id')[0]
                ],
                [
                    'description' => 'Clava',
                    'attack' => 1,
                    'defense' => 0,
                    'dice' => 8,
                    'fighter_id' => DB::table('fighters')
                        ->where('specie', 'Orc')
                        ->pluck('id')[0]
                ]
            ]
        );

    }
}
