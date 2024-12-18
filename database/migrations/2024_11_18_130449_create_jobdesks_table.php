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
        Schema::create('jobdesks', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('jabatans_id')
            ->nullable()   // memungkinkan nilai null jika tidak ada relasi
            ->constrained() // secara otomatis mengarah ke tabel jabatans
            ->onDelete('set null') // set null jika jabatan dihapus
            ->index('jobdesk_jabatan_id'); // menambahkan nama indeks

            $table->string('name')->unique();
            $table->text('deskripsi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobdesks');
    }
};
