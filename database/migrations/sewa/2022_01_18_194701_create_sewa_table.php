<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSewaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sewa', function (Blueprint $table) {
            $table->bigIncrements('id_sewa');
            $table->integer('status')->comment('1. disiapkan, 2. dikirim, 3. disewa, 4. selesai');
            $table->string('kode_pesanan')->references('kode_pesanan')->on('pesanan');
            $table->timestamp('waktu_pengiriman')->nullable();
            $table->timestamp('waktu_pengembalian')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sewa');
    }
}
