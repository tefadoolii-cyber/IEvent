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
        Schema::create('readiness_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('withdrawn_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('issued_at');
            $table->date('expires_at')->nullable();
            $table->enum('status', ['active', 'expired', 'withdrawn'])->default('active');
            $table->text('notes')->nullable();
            $table->text('withdrawal_reason')->nullable();
            $table->timestamp('withdrawn_at')->nullable();
            $table->timestamps();
            $table->index('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readiness_licenses');
    }
};
