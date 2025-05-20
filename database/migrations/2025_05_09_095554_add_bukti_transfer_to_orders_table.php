<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuktiTransferToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom bukti_transfer (untuk menyimpan path file)
            $table->string('bukti_transfer')->nullable(); // Kolom ini nullable agar bisa kosong
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kolom bukti_transfer jika migrasi di rollback
            $table->dropColumn('bukti_transfer');
        });
    }
}
