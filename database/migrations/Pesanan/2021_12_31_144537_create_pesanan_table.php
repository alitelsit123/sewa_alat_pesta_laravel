<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->string('kode_pesanan')->primary();
            $table->enum('status', ['1', '2', '3', '4'])->comment('1=menunggu pembayaran, 2=pembayaran_dp, 3=pembayaran_full, 4=kadaluarsa')->nullable();
            $table->integer('total_bayar');            

            $table->foreignId('id_user')->references('id_user')->on('users');

            $table->timestamps();
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
        Schema::dropIfExists('pesanan');
    }
}
