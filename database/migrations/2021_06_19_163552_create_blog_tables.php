<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image');
            $table->longText('content');
            $table->dateTime('publishedAt');
            $table->enum('status', ['aktif', 'draft']);
            // $table->uuid('user_id')->index();
            $table->unsignedBigInteger('user_id');
           
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('tags', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('post_tags', function(Blueprint $table) {
            // $table->uuid('post_id');
            // $table->uuid('tag_id');
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('posts');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('post_tags');
    }
}
