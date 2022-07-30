<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->string('name')->nullable();
            $table->boolean('device')->default(0); // 0 => PC, 1 => Movil
            $table->boolean('section')->default(0); // 0 => Banner
            $table->integer('position')->unsigned()->default(1);
            $table->string('url')->nullable();
            $table->integer('image_id')->unsigned()->default(2);
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
        Schema::dropIfExists('banners');
    }
}
