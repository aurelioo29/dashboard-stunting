<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Data form
            $table->unsignedTinyInteger('usia_bulan');
            $table->string('jenis_kelamin', 20);

            $table->decimal('bb_balita', 5, 2)->nullable();
            $table->decimal('tb_balita', 5, 2)->nullable();
            $table->decimal('bmi', 5, 2)->nullable();

            $table->string('imunisasi', 20)->nullable();
            $table->string('air_bersih', 10)->nullable();
            $table->string('sanitasi', 10)->nullable();

            // LANGSUNG RUPIAH
            $table->unsignedBigInteger('pendapatan_rupiah')->nullable();

            // Z-score
            $table->decimal('haz', 5, 2)->nullable();
            $table->decimal('waz', 5, 2)->nullable();
            $table->decimal('whz', 5, 2)->nullable();

            // Hasil prediksi
            $table->string('risk_level');
            $table->decimal('probability', 6, 4)->nullable();

            $table->json('contributions')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
