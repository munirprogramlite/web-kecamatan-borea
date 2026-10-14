<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('desa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained('kecamatan')->cascadeOnDelete();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('sambutan')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('letak_geografis')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat_balai')->nullable();
            $table->string('jam_layanan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desa');
    }
};