<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('stock')->nullable();
            $table->string('weight')->nullable();
            $table->string('measure')->nullable();
            $table->text('tags')->nullable();
            $table->integer('image_id')->default(1);
            $table->integer('document_id')->nullable();

            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('subcategories');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->integer('image_id')->unsigned();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');

            $table->primary(['product_id', 'image_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
