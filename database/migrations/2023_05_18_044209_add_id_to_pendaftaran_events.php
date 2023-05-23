<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToPendaftaranEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_events', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_events', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
