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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slugname');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['staff', 'admins','manager','dokter'])->default('staff');
            $table->string('nohp')->default('-');
            $table->string('nip')->default('-');
            $table->date('tglmasuk')->default('00/00/0000');
            $table->string('alamat')->default('-');
            $table->string('gambar')->default('-');
            $table->foreignId('jabatans_id')
            ->constrained() // tidak perlu parameter `table`
            ->nullable()    // memungkinkan nilai null
            ->onDelete('set null') // mengatur null jika data jabatan dihapus
            ->index('users_jabatans_id'); // Anda bisa menyertakan index jika perlu

            $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
        


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
