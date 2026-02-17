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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volume_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->integer('issue_number');
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('issue_type', ['regular', 'special', 'supplement'])->default('regular');
            $table->date('publication_date')->nullable();
            $table->enum('status', ['planned', 'in_progress', 'published'])->default('planned');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Ensure unique issue numbers within a volume
            $table->unique(['volume_id', 'issue_number']);
            $table->index(['volume_id', 'status']);
            $table->index('publication_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
