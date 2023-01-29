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
            $table->unsignedBigInteger('store_id');
           $table->foreign('store_id')->references('id')->on('stores');
            $table->unsignedBigInteger('category_id');
           $table->foreign('category_id')->references('id')->on('categories');     
            $table->string('name');
             $table->string('slug');
             $table->text('description')->nullable();
             $table->string('image')->nullable();
             $table->float('price')->default(0);
             $table->float('compare_price')->nullable();
             $table->json('options')->nullable();
            $table->float('rating')->default(0);
            $table->boolean('fetured')->default(0); 
             $table->enum('status',['Active','Archived','draft']); 
           
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
        Schema::dropIfExists('products');
    }
}