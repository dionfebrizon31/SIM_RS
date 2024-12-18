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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            // Memisahkan tanggal, bulan, dan tahun sebagai string
            $table->string('tgl')->nullable();    // Format: 'DD'
            $table->string('bln')->nullable();    // Format: 'MM'
            $table->string('tahun')->nullable();  // Format: 'YYYY'
            $table->enum('status', ['checkin','latest', 'checkout','alpha'])->default('alpha');
            $table->timestamp('absen_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
