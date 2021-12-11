<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id_profile');
            $table->string('nama');
            $table->string('telepon', 15);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->integer('kodepos');
            $table->string('pekerjaan')->nullable();
            $table->text('photo');
            $table->foreignId('id_user')->references('id_user')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
