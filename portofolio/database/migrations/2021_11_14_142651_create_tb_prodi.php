<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProdi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_prodi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fakultas_id');
            $table->unsignedBigInteger('jurusan_id');
            $table->string('nama_prodi', 191);
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('fakultas_id')->references('id')->on('tb_fakultas')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('jurusan_id')->references('id')->on('tb_jurusan')
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
        Schema::dropIfExists('tb_prodi');
    }
}
