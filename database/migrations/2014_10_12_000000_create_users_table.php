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
            $table->id();
            $table->string('FullName');
            $table->string('LastNames');
            $table->string('NumberId')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->integer('typeUser');
            $table->integer('typeNumberId');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
