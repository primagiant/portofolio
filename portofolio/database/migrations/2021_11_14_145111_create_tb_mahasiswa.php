<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 10)->unique();
            $table->string('nama', 191);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pembimbing_akademik_id')->nullable();
            $table->unsignedBigInteger('angkatan_id');
            $table->unsignedBigInteger('fakultas_id');
            $table->unsignedBigInteger('jurusan_id');
            $table->unsignedBigInteger('prodi_id');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pembimbing_akademik_id')->references('id')->on('tb_pembimbing_akademik')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('angkatan_id')->references('id')->on('tb_angkatan')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fakultas_id')->references('id')->on('tb_fakultas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jurusan_id')->references('id')->on('tb_jurusan')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('prodi_id')->references('id')->on('tb_prodi')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_mahasiswa');
    }
}
