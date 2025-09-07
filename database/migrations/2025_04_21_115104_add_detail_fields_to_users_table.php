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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_pengguna')->after('nip');
            $table->string('posisi')->nullable()->after('nama_pengguna');
            $table->string('tugas')->nullable()->after('posisi');
            $table->string('foto')->nullable()->after('tugas');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nama_pengguna', 'posisi', 'tugas', 'foto']);
        });
    }
};
