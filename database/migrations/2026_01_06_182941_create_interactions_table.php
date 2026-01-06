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
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->foreignId('organization_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['email', 'call', 'meeting', 'event', 'note', 'other'])->default('note');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->dateTime('date');
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->enum('outcome', ['positive', 'neutral', 'negative'])->nullable();
            $table->text('next_steps')->nullable();
            $table->json('attachments')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('contact_id');
            $table->index('organization_id');
            $table->index('type');
            $table->index('date');
            $table->index('outcome');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};
