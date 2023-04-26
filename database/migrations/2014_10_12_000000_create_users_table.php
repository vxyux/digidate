<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->onDelete('cascade');
            $table->string('one_time');
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('password');
            $table->string('first_name');
            $table->string('infix')->nullable();
            $table->string('last_name');
            $table->date('dob');
            $table->integer('gender')->nullable();
            $table->integer('orientation')->nullable();
            $table->integer('phone')->nullable();
            $table->string('street_nr')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address');
            $table->string('country');
            $table->string('description')->nullable();
            $table->integer('is_enterprise')->nullable();
            $table->boolean('is_admin');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
    }
};
