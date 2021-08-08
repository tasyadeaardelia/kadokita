<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('cover');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->float('price');
            $table->float('weight');
            $table->float('stock');
            $table->string('photo');
            $table->text('description');
            $table->unsignedBigInteger('store_id');
            $table->foreign('store_id')->references('id')->on('store');
            $table->timestamps();
        });

        Schema::create('product_categories', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')
            ->onUpdate('cascade');;
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')
            ->onUpdate('cascade');;
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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('product_categories');
    }
}
