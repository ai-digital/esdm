<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->string('nama_menu', 100)->nullable();
            $table->string('keterangan')->nullable();
            $table->string('path', 100)->nullable();
            $table->string('slug', 100)->nullable();
            $table->string('status_menu', 100)->nullable()->default('tidak ada');

            $table->foreign('parent_id')->references('id')->on('dokumens')->onDelete('cascade');
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
        Schema::dropIfExists('dokumens');
    }
};
