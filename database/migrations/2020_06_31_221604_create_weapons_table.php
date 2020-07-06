<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('attack');
            $table->integer('defense');
            $table->integer('dice');
            
            $table->unsignedBigInteger('fighter_id')->unsigned()->nullable();
            $table->foreign('fighter_id')
                ->references('id')
                ->on('fighters');

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
        Schema::dropIfExists('weapons');
    }
}
