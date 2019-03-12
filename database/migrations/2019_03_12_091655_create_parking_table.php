<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->tinyInteger('status');
			$table->tinyInteger('fast_charging');
			$table->integer('capacity');
			$table->integer('price');
			$table->string('latitude');
			$table->string('longitude');
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
        Schema::dropIfExists('parking');
    }
}
