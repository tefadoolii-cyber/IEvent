<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lookup_groups', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();           // location_types
            $table->string('name_ar');                  // أنواع المواقع
            $table->string('name_en')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false); // نظام (ما يتحذف)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lookup_groups');
    }
};
