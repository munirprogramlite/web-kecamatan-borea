<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('warga_agregat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desa')->cascadeOnDelete();
            $table->string('periode'); // contoh: "2026"
            $table->integer('jumlah_kk')->default(0);
            $table->integer('jumlah_laki')->default(0);
            $table->integer('jumlah_perempuan')->default(0);
            $table->integer('usia_0_14')->default(0);
            $table->integer('usia_15_64')->default(0);
            $table->integer('usia_65_plus')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga_agregat');
    }
};