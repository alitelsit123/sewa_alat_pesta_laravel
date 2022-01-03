<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->bigIncrements('id_detail_pesanan');
            $table->integer('kuantitas');
            $table->string('kode_produk')->references('kode_produk')->on('produk');
            $table->string('kode_pesanan')->references('kode_pesanan')->on('pesanan');
            $table->bigInteger('total_harga')->comment('kuantitas*harga');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pesanan');
    }
}
