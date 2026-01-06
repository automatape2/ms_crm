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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['email', 'event', 'survey'])->default('email');
            $table->enum('status', ['draft', 'scheduled', 'active', 'completed', 'paused'])->default('draft');
            $table->foreignId('segment_id')->nullable()->constrained()->onDelete('set null');
            $table->dateTime('scheduled_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->json('stats')->nullable(); // {sent, opened, clicked, replied}
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('name');
            $table->index('type');
            $table->index('status');
            $table->index('segment_id');
            $table->index('scheduled_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
