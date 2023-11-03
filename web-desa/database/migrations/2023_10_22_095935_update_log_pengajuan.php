<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('log_pengajuans', function (Blueprint $table) {
            $table->dropColumn('admin_id');
            $table->bigInteger('user_id')
                ->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_pengajuans', function (Blueprint $table) {
            $table->dropColumn('admin');
            $table->bigInteger('admin_id')
                ->comment('Admin yang mereview pangajuan')
                ->after('status');
        });
    }
};
