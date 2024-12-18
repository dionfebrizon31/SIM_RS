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
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->foreignId('users_id')
            ->constrained() // tidak perlu parameter `table`
            ->nullable()    // memungkinkan nilai null
            ->index('users_cutis_id'); // Anda bisa menyertakan index jika perlu
            $table->foreignId('jeniscutis_id')
            ->constrained() // tidak perlu parameter `table`
            ->nullable()    // memungkinkan nilai null
            ->index('jenis_cutis_id'); // Anda bisa menyertakan index jika perlu
            $table->date('awalcuti');
            $table->date('akhircuti');
            $table->enum('status',['approved','pending','reject']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
