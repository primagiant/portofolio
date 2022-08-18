<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPortofolio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_portofolio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('kategori_kegiatan_id');
            $table->unsignedBigInteger('jenis_kegiatan_id');
            $table->integer('valid_point');
            $table->string('nama_kegiatan', 191);
            $table->string('penyelenggara', 191);
            $table->string('tahun', 4);
            $table->unsignedBigInteger('semester_id');
            $table->string('bukti', 255);
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('validator_id')->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('tb_mahasiswa')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('tb_semester')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kategori_kegiatan_id')->references('id')->on('tb_kategori_kegiatan')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jenis_kegiatan_id')->references('id')->on('tb_jenis_kegiatan')
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
        Schema::dropIfExists('tb_portofolio');
    }
}
