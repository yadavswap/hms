<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bed_assigns', function (Blueprint $table) {
            $table->unsignedInteger('ipd_patient_department_id')->nullable()->after('bed_id');

            $table->foreign('ipd_patient_department_id')->references('id')->on('ipd_patient_departments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bed_assigns', function (Blueprint $table) {
            $table->dropColumn('ipd_patient_department_id');
        });
    }
};
