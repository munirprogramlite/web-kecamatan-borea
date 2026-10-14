<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->cascadeOnDelete();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('menu')->nullable();       // daftar menu & harga (teks bebas)
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();   // nomor WhatsApp
            $table->string('status')->default('tayang'); // tayang | nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};