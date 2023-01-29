<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
             $table->uuid('cookie_id');
              $table->unsignedBigInteger('user_id');
              $table->foreign('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete(); 
             $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->nullable()->references('id')->on('products')->cascadeOnDelete(); 
            $table->unsignedBigInteger('quantity')->default(1);
            $table->json('option')->nullable();
            $table->timestamps();
            $table->unique(['cookie_id','product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}