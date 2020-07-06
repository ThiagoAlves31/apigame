<?php

use Illuminate\Database\Seeder;

class FighterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('fighters')->insert(
            [
                [
                    'name' => 'Krouthu',
                    'specie'  => 'Orc',
                    'life'    => 20,
                    'force'   => 2,
                    'agility' => 0,
                    'weapon_id' => 2
                ],
                [
                    'name' => 'Joker',
                    'specie'  => 'Human',
                    'life'    => 12,
                    'force'   => 1,
                    'agility' => 2,
                    'weapon_id' => 1
                ]
            ]
        );
    }
}
