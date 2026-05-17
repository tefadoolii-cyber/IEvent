<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('employees')) {
            return;
        }

        Schema::create('employees', function (Blueprint $table) {
            $table->id();                           // رقم تعريفي تلقائي
            $table->string('name');                 // اسم الموظف
            $table->string('employee_number')->unique(); // رقم الموظف
            $table->string('phone')->nullable();    // رقم الجوال
            $table->string('email')->nullable();    // الإيميل
            $table->string('department')->nullable(); // القسم
            $table->string('position')->nullable(); // المسمى الوظيفي
            $table->enum('status', ['active', 'inactive'])->default('active'); // الحالة
            $table->timestamps();                   // تاريخ الإنشاء والتعديل
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
