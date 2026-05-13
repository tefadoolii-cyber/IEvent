<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lookups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('lookup_groups')->cascadeOnDelete();
            $table->string('value_ar');                 // مركز ضيافة
            $table->string('value_en')->nullable();
            $table->string('code')->nullable();         // كود اختياري
            $table->string('color')->nullable();        // للحالات (أخضر/أحمر...)
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['group_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lookups');
    }
};
