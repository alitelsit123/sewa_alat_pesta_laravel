<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->string('kode_pembayaran')->primary();
            $table->string('snap_token', 36)->nullable();
            $table->bigInteger('total_bayar');
            $table->string('jenis_pembayaran', 64)->comment('Bank, Official Store, dll.')->nullable();
            $table->enum('tipe_pembayaran', ['1', '2'])->comment('1=dp, 2=full');
            $table->enum('status', ['1', '2', '3'])->comment('1=pending, 2=sukses');

            $table->string('kode_pesanan')->references('kode_pesanan')->on('pesanan');

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
        Schema::dropIfExists('pembayaran');
    }
}
