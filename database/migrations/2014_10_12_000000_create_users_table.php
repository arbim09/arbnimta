<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->datetime('tanggal_lahir');
            $table->integer('umur')->nullable();
            $table->text('alamat');
            $table->enum('agama', ['Islam', 'Kristen', 'Katholik', 'Hindu','Budha', 'Khonghucu', 'Lainya']);
            $table->enum('pendidikan', ['Tidak/Belum Sekolah', 'Belum Tamat SD/Sederajat', 'Tamat SD/Sederajat', 'SLTP/Sederajat','SLTA/Sederajat', 'Diploma I/II', 'Akademi/Diploma III/S. muda', 'Diploma IV/Strata I', 'Strata II', 'Strata III'])->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('pekerjaan_id')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('role',['admin','pengurus','anggota'])->default('anggota')->nullable();
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
        Schema::dropIfExists('users');
    }
}
