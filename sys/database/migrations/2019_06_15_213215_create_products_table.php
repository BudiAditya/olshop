<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 40);
            $table->text('deskripsi');
            $table->integer('kategori_id');
            $table->integer('satuan_id');
            $table->integer('tag_id')->nullable();
            $table->string('berat', 4)->nullable();
            $table->integer('harga_beli')->nullable();;
            $table->integer('harga_jual');
            $table->text('gambar');
            $table->string('rating', 1);
            $table->string('dilihat', 10);
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
        Schema::dropIfExists('products');
    }
}
