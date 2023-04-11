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
        Schema::table('beritas', function (Blueprint $table) {
            $table->string('gambar', 200)->nullable()->after('slug');
            $table->unsignedBigInteger('kategori_id')->nullable()->after('thumbnail');
            $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('tags')->nullable()->after('kategori_id');
            $table->unsignedBigInteger('user_id')->after('tags');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beritas', function (Blueprint $table) {
            //
        });
    }
};
