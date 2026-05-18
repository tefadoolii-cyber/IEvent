<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'start_date')) {
                $table->date('start_date')->nullable()->after('position');
            }
            if (!Schema::hasColumn('employees', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('employees', 'contract_status')) {
                $table->string('contract_status')->nullable()->after('end_date');
            }
            if (!Schema::hasColumn('employees', 'photo')) {
                $table->string('photo')->nullable()->after('contract_status');
            }
            if (!Schema::hasColumn('employees', 'cv_file')) {
                $table->string('cv_file')->nullable()->after('photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['start_date', 'end_date', 'contract_status', 'photo', 'cv_file'],
                fn($col) => Schema::hasColumn('employees', $col)
            ));
        });
    }
};
