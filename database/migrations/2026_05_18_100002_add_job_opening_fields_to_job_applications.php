<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('job_applications', 'job_opening_id')) {
                $table->foreignId('job_opening_id')->nullable()->after('id')
                      ->constrained('job_openings')->onDelete('set null');
            }
            if (!Schema::hasColumn('job_applications', 'id_photo')) {
                $table->string('id_photo')->nullable()->after('cv_file');
            }
            if (!Schema::hasColumn('job_applications', 'iban_photo')) {
                $table->string('iban_photo')->nullable()->after('id_photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign(['job_opening_id']);
            $table->dropColumn(['job_opening_id', 'id_photo', 'iban_photo']);
        });
    }
};
