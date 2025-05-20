<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderTimeToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom order_time dengan tipe timestamp
            $table->timestamp('order_time')->nullable();  // Kolom ini nullable jika Anda tidak ingin menyetelnya secara manual
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kolom order_time jika migrasi di rollback
            $table->dropColumn('order_time');
        });
    }
}
