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
        Schema::create('journal_review_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->onDelete('set null'); // Admin who assigned
            
            // Review details
            $table->enum('review_type', ['single_blind', 'double_blind', 'open'])->default('single_blind');
            $table->enum('status', [
                'pending', 
                'accepted', 
                'declined', 
                'in_progress', 
                'completed', 
                'cancelled'
            ])->default('pending');
            
            // Review content
            $table->text('comments_to_editor')->nullable(); // Confidential comments
            $table->text('comments_to_author')->nullable(); // Comments visible to author
            $table->enum('recommendation', [
                'accept', 
                'minor_revisions', 
                'major_revisions', 
                'reject', 
                'resubmit'
            ])->nullable();
            
            // Review quality metrics
            $table->integer('originality_score')->nullable()->unsigned(); // 1-5
            $table->integer('methodology_score')->nullable()->unsigned(); // 1-5
            $table->integer('presentation_score')->nullable()->unsigned(); // 1-5
            $table->integer('overall_score')->nullable()->unsigned(); // 1-5
            
            // Dates
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('responded_at')->nullable(); // When reviewer accepts/declines
            $table->timestamp('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            
            // Metadata
            $table->text('decline_reason')->nullable();
            $table->text('notes')->nullable(); // Admin notes
            $table->timestamps();
            
            // Ensure one assignment per journal-reviewer combination
            $table->unique(['journal_id', 'reviewer_id']);
            
            $table->index(['journal_id', 'status']);
            $table->index(['reviewer_id', 'status']);
            $table->index('due_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_review_assignments');
    }
};
