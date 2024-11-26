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
        Schema::create('refferal_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cus_id')->nullable();
            $table->foreign('cus_id')->references('id')->on('customers');
            $table->string('ref_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refferal_codes');
    }
};
