<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول تعريف الحقول
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');           // الجدول (employees, contracts...)
            $table->string('field_key');             // مفتاح الحقل (id_number)
            $table->string('field_label');           // اسم العرض (رقم الهوية)
            $table->string('field_type');            // text, number, date, select, textarea
            $table->text('options')->nullable();     // للقوائم المنسدلة (JSON)
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // جدول قيم الحقول
        Schema::create('custom_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_field_id')->constrained()->onDelete('cascade');
            $table->string('record_table');          // اسم الجدول
            $table->unsignedBigInteger('record_id'); // الـ ID للسجل
            $table->text('value')->nullable();
            $table->timestamps();

            $table->index(['record_table', 'record_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_field_values');
        Schema::dropIfExists('custom_fields');
    }
};
