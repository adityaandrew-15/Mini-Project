<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('type');  // Jenis transaksi (obat, peralatan, transaksi pasien)
            $table->string('action');  // Misalnya: 'added', 'removed', 'used', 'payment'
            $table->unsignedBigInteger('reference_id')->nullable();  // ID referensi dari tabel lain
            $table->json('details');  // Menyimpan detail data dalam format JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
