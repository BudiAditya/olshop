<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->bigIncrements('transaksi_id');
            $table->integer('customer_id')->nullable();
            $table->integer('is_guest')->nullable();
            $table->integer('alamat_id');
            $table->string('status_pembayaran');
            $table->string('kurir')->nullable();
            $table->string('kurir_service')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('status_pengiriman')->nullable();
            $table->string('status_transaksi');
            $table->string('jenis_pembayaran');
            $table->string('voucher')->nullable();
            $table->string('ongkir')->nullable();
            $table->string('diskon')->nullable();
            $table->string('kode_unik');
            $table->string('total_transaksi');
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('transaksis');
    }
}
