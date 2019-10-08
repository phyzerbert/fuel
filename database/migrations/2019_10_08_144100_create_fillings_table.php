<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fillings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_no')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('tank_id')->nullable();
            $table->integer('amount')->nullable();
            $table->date('filling_date')->nullable();
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
        Schema::dropIfExists('fillings');
    }
}
