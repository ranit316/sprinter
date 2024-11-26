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
        Schema::table('app_infos', function (Blueprint $table) {
            $table->string('whats_app_4')->nullable();
            $table->string('whats_app_5')->nullable();
            $table->string('whats_app_6')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_infos', function (Blueprint $table) {
            //
        });
    }
};
