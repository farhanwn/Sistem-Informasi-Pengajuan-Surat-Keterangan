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
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('kode_surat')
                ->after('id');
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->after('id');
            $table->text('scan_akta')
                ->after('status');
            $table->text('scan_kk')
                ->after('status');
            $table->text('scan_ktp')
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn(['kode_surat', 'user_id', 'scan_akta', 'scan_kk', 'scan_ktp']);
        });
    }
};
