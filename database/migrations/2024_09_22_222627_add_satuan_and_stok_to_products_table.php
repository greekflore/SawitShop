<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSatuanAndStokToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('satuan')->after('price'); // Tambahkan kolom 'satuan' setelah kolom 'price'
            $table->integer('stok')->after('satuan'); // Tambahkan kolom 'stok' setelah kolom 'satuan'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['satuan', 'stok']); // Hapus kolom 'satuan' dan 'stok' jika rollback
        });
    }
}
