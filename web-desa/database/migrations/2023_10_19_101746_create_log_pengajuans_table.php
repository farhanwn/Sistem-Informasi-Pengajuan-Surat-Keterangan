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
        Schema::create('log_pengajuans', function (Blueprint $table) {
            $table->bigInteger('pengajuan_id');
            $table->tinyInteger('status');
            $table->bigInteger('admin')->comment('Admin yang mereview pengajuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_pengajuans');
    }
};
