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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
            $table->foreignId('organization_id')->nullable()->constrained()->onDelete('set null');
            $table->json('tags')->nullable();
            $table->json('custom_fields')->nullable();
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->enum('source', ['manual', 'import', 'form', 'api'])->default('manual');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('email');
            $table->index('organization_id');
            $table->index('status');
            $table->index('source');
            $table->index(['first_name', 'last_name']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
