<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendindStatusToDeleveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deleveries', function (Blueprint $table) {
            DB::statement("ALTER TABLE `deleveries`
                CHANGE COLUMN `status` `status` ENUM('pending','in-progress','delivered') NOT NULL DEFAULT 'pending'
            ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deleveries', function (Blueprint $table) {
            //
        });
    }
}