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
        // Handled by 2026_05_16_163746_create_assignments_v2_table.php
        // which runs after companies table is created
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // handled in v2 migration
    }
};
