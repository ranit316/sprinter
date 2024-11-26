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
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('name');          
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive']);            
            $table->string('photo')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->foreignId('platform_id')->nullable()->references('id')->on('platforms');
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->string('result_link')->nullable();
            $table->string('cta_type')->nullable();
            $table->string('cta_link')->nullable();
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users');
            $table->foreignId('deleted_by')->nullable()->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contests');
    }
};
