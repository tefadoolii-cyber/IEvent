<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();        // مفتاح فريد (employees, attendance...)
            $table->string('name');                 // اسم العرض بالعربي
            $table->string('icon')->nullable();     // أيقونة Bootstrap
            $table->string('route')->nullable();    // الرابط
            $table->string('parent')->nullable();   // الإدارة الأب (hr, ops, quality...)
            $table->integer('order')->default(0);   // الترتيب
            $table->boolean('is_active')->default(true);  // ظاهر أو مخفي
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};