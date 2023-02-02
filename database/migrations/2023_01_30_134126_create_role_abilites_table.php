<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleAbilitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_abilites', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();
            $table->string('ability');
            $table->enum('type', ['allow', 'deny', 'inherit']);
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
        Schema::dropIfExists('role_abilites');
    }
}