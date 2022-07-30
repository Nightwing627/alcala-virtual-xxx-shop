<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('total',8,2);
            $table->decimal('subtotal',8,2);
            $table->string('PaymentMethod')->nullable();
            $table->decimal('shippingCost',8,2)->nullable();
            $table->string('street');
            $table->String('num_ext')->nullable();
            $table->String('num_int')->nullable();
            $table->string('neighborhood');
            $table->string('postalCode');
            $table->string('status');
            
            $table->integer('customer_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('town_id')->unsigned();
            $table->integer('document_id')->unsigned()->nullable();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('town_id')->references('id')->on('towns');

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
        Schema::dropIfExists('orders');
    }
}
