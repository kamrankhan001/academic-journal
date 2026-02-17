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
        Schema::table('journals', function (Blueprint $table) {
            $table->foreignId('volume_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('issue_id')->nullable()->constrained()->nullOnDelete();
            
            // Additional fields for journal management
            $table->enum('review_type', ['single_blind', 'double_blind', 'open'])->default('single_blind');
            $table->enum('decision', ['pending', 'accepted', 'rejected', 'minor_revisions', 'major_revisions'])->default('pending');
            $table->timestamp('decision_communicated_at')->nullable();
            $table->integer('page_start')->nullable();
            $table->integer('page_end')->nullable();
            $table->string('doi')->nullable()->unique();
            
            // Add indexes
            $table->index(['volume_id', 'issue_id']);
            $table->index('doi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropForeign(['volume_id']);
            $table->dropForeign(['issue_id']);
            $table->dropColumn([
                'volume_id', 
                'issue_id', 
                'review_type',
                'decision',
                'decision_communicated_at',
                'page_start',
                'page_end',
                'doi'
            ]);
        });
    }
};
