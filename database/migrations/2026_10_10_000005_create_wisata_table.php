<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wisata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->cascadeOnDelete();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('harga_tiket')->nullable();
            $table->string('jam_buka')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->string('status')->default('tayang'); // tayang | nonaktif
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wisata');
    }
};