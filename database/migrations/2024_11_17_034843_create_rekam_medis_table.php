<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungans')->onDelete('cascade');
            $table->unsignedBigInteger('pasien_id'); // Menambah kolom pasien_id

            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade'); // Perbaiki nama tabel 'pasiens' di sini
            $table->text('diagnosa'); // Kolom untuk diagnosa
            $table->text('tindakan'); // Kolom untuk tindakan
            $table->string('image')->nullable(); // Membuat image nullable

            // $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); // Status pembayaran
            $table->decimal('total_payment', 15, 2)->nullable(); // Jumlah pembayaran, dengan format desimal

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
