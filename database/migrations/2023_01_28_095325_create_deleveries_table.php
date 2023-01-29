<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeleveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleveries', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();
            // You can add another Foreign ID for the delivery company/person
            $table->point('current_location')->nullable();
            $table
                ->enum('status', ['in-progress', 'delivered'])
                ->default('in-progress');
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
        Schema::dropIfExists('deleveries');
    }
}