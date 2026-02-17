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
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('volume_number')->unique();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->year('year');
            $table->enum('status', ['planned', 'in_progress', 'published'])->default('planned');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index('volume_number');
            $table->index('year');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volumes');
    }
};
