<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('target_tipe'); // umkm | wisata
            $table->unsignedBigInteger('target_id');
            $table->text('isi');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamps();

            $table->index(['target_tipe', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};