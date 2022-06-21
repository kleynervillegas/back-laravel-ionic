<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('description',1000);
            $table->string('origin',1000);
            $table->boolean('send_user',1000);
            $table->foreignId('id_product')->unsigned()->default(0);	
            $table->foreignId('id_user')->unsigned()->default(0);	
            $table->foreignId('id_user_origin')->unsigned()->default(0);	
            $table->timestamps();
            $table->softDeletes(); 
            //-Constraints
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_user_origin')->references('id')->on('users');
            $table->foreign('id_product')->references('id')->on('products');
 
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
}
