<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShipmentColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_address')->nullable();
            $table->foreign('id_address')->references('id_address')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('pesanan', function (Blueprint $table) {
        //     $table->dropForeign(['id_address']);
        //     $table->dropColumn('id_address');
        // });
    }
}
