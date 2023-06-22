<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_gambar_laman', function (Blueprint $table) {
            $table->id();
            $table->string('nm_gambar');
            $table->string('file_gambar');
            $table->unsignedBigInteger('laman_id');
            $table->foreign('laman_id')->references('id')->on('lamen')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on("users")->onDelete('cascade');
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
        Schema::dropIfExists('upload_gambar_laman');
    }
};