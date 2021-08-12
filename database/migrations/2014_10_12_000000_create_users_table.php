<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // $table->uuid('id')->primary();
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profil')->default('undraw_profile.svg')->nullable();
            $table->string('fullname');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('account_number')->nullable();
            $table->string('id_card')->nullable();
            $table->string('npwp')->nullable();
            $table->rememberToken();
            $table->timestamps();

        });

        Schema::create('store', function(Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable();
            $table->string('url')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('profil')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
            ->onUpdate('cascade');;

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
        Schema::dropIfExists('users');
        Schema::dropIfExists('shops');
    }
}
