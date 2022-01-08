<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatSesiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_sesi', function (Blueprint $table) {
            $table->bigIncrements('id_chat_sesi');

            $table->foreignId('id_user')->references('id_user')->on('users');
            $table->foreignId('id_admin')->references('id_user')->on('users');

            $table->enum('status', ['1', '2'])->comment('1. tidak terkoneksi, 2. terkoneksi');

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
        Schema::dropIfExists('chat_sesi');
    }
}