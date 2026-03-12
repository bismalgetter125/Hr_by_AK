<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'qa' as a valid status value
        DB::statement("ALTER TABLE tasks MODIFY COLUMN status ENUM('to_do', 'in_progress', 'qa', 'completed') DEFAULT 'to_do'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum without 'qa'
        DB::statement("ALTER TABLE tasks MODIFY COLUMN status ENUM('to_do', 'in_progress', 'completed') DEFAULT 'to_do'");
    }
};

