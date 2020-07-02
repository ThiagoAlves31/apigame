<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->integer('round_number');
            $table->integer('action');
            $table->integer('value_dice_human');
            $table->integer('value_dice_orc');
            $table->integer('attack')->nullable();

            $table->integer('battles_id')->unsigned();
            $table->foreign('id')
                  ->references('id')
                  ->on('battles')
                  ->onDelete('cascade');
                  
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
        Schema::dropIfExists('rounds');
    }
}
