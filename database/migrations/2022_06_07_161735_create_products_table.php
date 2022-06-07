<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name',50);
            $table->string('description',1000);
            $table->string('coin');
            $table->double('price');	
            $table->integer('stopMin');
            $table->integer('stopMax');
            $table->json('image');
            $table->foreignId('id_user')->unsigned();	
            $table->timestamps();
            $table->softDeletes();      
            //-Constraints
            $table->foreign('id_user')->references('id')->on('users');
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
