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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('module');          
            $table->text('message')->nullable();
            $table->enum('is_read', ['read', 'unread'])->default('unread'); 
            $table->enum('is_openabl', ['yes', 'no'])->default('yes');  
            $table->string('permissions')->nullable();  
            $table->string('action')->nullable();   
            $table->string('table')->nullable();    
            $table->bigInteger('table_id')->nullable();             
           
            $table->softDeletes();
                               
             $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users');
            $table->foreignId('deleted_by')->nullable()->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
