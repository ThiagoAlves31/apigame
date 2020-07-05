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
        factory(App\Fighter::class,4)->create();
    }
}
