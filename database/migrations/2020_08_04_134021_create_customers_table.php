<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street');
            $table->string('num_ext');
            $table->string('num_int')->nullable();
            $table->string('neighborhood');
            $table->string('postalCode');
            $table->integer('state_id')->unsigned();
            $table->integer('town_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('price', ['A', 'B', 'C', 'D'])->default('A');

            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade");
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
        Schema::dropIfExists('customers');
    }
}
