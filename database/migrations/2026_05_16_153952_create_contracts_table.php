<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('contract_number')->unique();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('position')->nullable();
            $table->text('terms')->nullable();
            $table->string('pdf_file')->nullable();
            $table->text('signature')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->enum('status', ['draft', 'sent', 'signed', 'cancelled'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};