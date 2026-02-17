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
        Schema::create('reviewers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('institution');
            $table->string('department')->nullable();
            $table->string('orcid_id')->nullable();
            $table->text('bio')->nullable();
            $table->json('expertise_areas')->nullable();
            $table->string('academic_degree')->nullable(); // PhD, MD, etc.
            $table->string('country')->nullable();
            $table->integer('review_count')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamps();

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewers');
    }
};
