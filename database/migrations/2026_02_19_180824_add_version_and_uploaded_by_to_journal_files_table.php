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
        Schema::table('journal_files', function (Blueprint $table) {
            $table->integer('version')->default(1)->after('file_type');

            $table->foreignId('uploaded_by')
                ->nullable()
                ->after('version')
                ->constrained('users')
                ->nullOnDelete();

            $table->index(['journal_id', 'file_type', 'version']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journal_files', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn(['version', 'uploaded_by']);
        });
    }
};
