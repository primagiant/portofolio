<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbJenisKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_jenis_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 191);
            $table->unsignedBigInteger('kategori_kegiatan_id');
            $table->string('ref_point', 30);
            $table->timestamps();

            $table->foreign('kategori_kegiatan_id')->references('id')->on('tb_kategori_kegiatan')
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
        Schema::dropIfExists('tb_jenis_kegiatan');
    }
}
