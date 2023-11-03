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
        Schema::table('log_pengajuans', function (Blueprint $table) {
            $table->string('catatan')
                ->nullable()
                ->after('status');

            // $table->renameColumn('admin', 'admin_id');

            $table->dropColumn('admin');
            $table->bigInteger('admin_id')
                ->comment('Admin yang mereview pangajuan')
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_pengajuans', function (Blueprint $table) {
            $table->dropColumn(['catatan']);
            // $table->renameColumn('admin_id', 'admin');

            $table->dropColumn('admin_id');
            $table->bigInteger('admin')
                ->comment('Admin yang mereview pangajuan')
                ->after('status');
        });
    }
};
