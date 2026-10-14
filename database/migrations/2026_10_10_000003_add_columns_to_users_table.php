<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_akun')->unique()->after('name');
            $table->string('peran')->default('warga')->after('nama_akun'); // admin | warga
            $table->foreignId('desa_id')->nullable()->after('peran')
                  ->constrained('desa')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('desa_id');
            $table->dropColumn(['nama_akun', 'peran']);
        });
    }
};