<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnloadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unloadings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_no')->nullable();
            $table->dateTime('timestamp')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('tank_id')->nullable();
            $table->integer('vehicle_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('first_km_hr')->nullable();
            $table->integer('last_km_hr')->nullable();
            $table->integer('diff_km_hr')->nullable();
            $table->integer('amount')->nullable();
            $table->string('attachment')->nullable();
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('unloadings');
    }
}
