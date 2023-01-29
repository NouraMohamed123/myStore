<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
              $table->primary('user_id');
              $table->unsignedBigInteger('user_id');
             $table->foreign('user_id')->references('id')->on('users');
            $table->string('first_name');
             $table->string('last_name');
            $table->date('birthday');
            $table->enum('gender',['male','female'])->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
               $table->string('state')->nullable();
             $table->string('postal_code')->nullable();
             $table->char('country',2)->nullable();
             $table->char('local',2)->default('en');
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
        Schema::dropIfExists('profiles');
    }
}