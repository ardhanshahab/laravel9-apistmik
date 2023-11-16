<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwalmatakuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('hari');
            $table->string('kd_mk');
            $table->string('nama_dosen');
            $table->string('masuk');
            $table->string('selesai');
            $table->string('kelas');
            $table->string('ruangan');
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
        Schema::dropIfExists('jadwalmatakuliahs');
    }
};
