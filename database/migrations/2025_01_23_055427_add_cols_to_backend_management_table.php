<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('backend_management', function (Blueprint $table) {
            $table->string('father_aadhar_no',126)->after('father_dob')->nullable();
            $table->string('mother_aadhar_no',126)->after('mother_dob')->nullable();
            $table->string('spouse_aadhar_no',126)->after('spouse_name')->nullable();
            $table->date('spouse_dob')->after('spouse_aadhar_no')->nullable();
            $table->string('family_photo',256)->after('photo')->nullable();
            $table->integer('hr_approval')->after('dcs_approval')->nullable();
            $table->integer('document_approval')->after('hr_approval')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backend_management', function (Blueprint $table) {
            $table->dropcolumn('father_aadhar_no', 'mother_aadhar_no', 'spouse_aadhar_no', 'spouse_dob', 'family_photo', 'hr_approval', 'document_approval');

        });
    }
};
