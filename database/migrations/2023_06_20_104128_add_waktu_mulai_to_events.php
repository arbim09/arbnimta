<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaktuMulaiToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->datetime('waktu_mulai')->nullable();
            $table->time('jam')->nullable();
            $table->enum('ondar', ['Daring', 'Luring'])->nullable();
            $table->string('pilih_keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('waktu_mulai');
            $table->dropColumn('jam');
            $table->dropColumn('pilih_keterangan');
            $table->dropColumn('ondar');
        });
    }
}
