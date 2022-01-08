<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnJudulPriorityChatBotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_bot', function (Blueprint $table) {
            $table->string('judul')->after('id_chat_bot')->nullable();
            $table->string('prioritas')->after('id_chat_bot')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_bot', function (Blueprint $table) {
            $table->dropColumn(['judul','prioritas']);
        });
    }
}
