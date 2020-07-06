<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBattlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->id('id');
            $table->integer('human_life')->default(12);
            $table->integer('orc_life')->default(20);
            
            $table->unsignedBigInteger('human_id');
            $table->foreign('human_id')
                ->references('id')
                ->on('fighters');
            
            $table->unsignedBigInteger('orc_id');
            $table->foreign('orc_id')
                ->references('id')
                ->on('fighters');

            $table->string('win')->nullable();
            $table->integer('win_id')->unsigned()->nullable();
            $table->integer('rounds')->unsigned()->nullable();
            
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
        Schema::dropIfExists('battles');
    }
}
