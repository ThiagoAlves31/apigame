<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFightersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fighters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('life');
            $table->integer('force');
            $table->integer('agility');
            $table->string('specie');
            $table->integer('battles')->default(0);
            $table->integer('wins')->default(0);;
            $table->integer('loss')->default(0);;

        /*     $table->unsignedBigInteger('weapon_id');
            $table->foreign('weapon_id')
                ->references('id')
                ->on('weapons'); */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fighters');
    }
}
