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
            $table->bigInteger('father_dob')->after('father_name')->nullable();
            $table->bigInteger('mother_dob')->after('mother_name')->nullable();
            $table->bigInteger('emer_name')->after('emer_contact_no')->nullable();
            $table->bigInteger('emer_relation')->after('emer_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backend_management', function (Blueprint $table) {
            $table->dropcolumn('father_dob', 'mother_dob', 'emer_name', 'emer_relation');

        });
    }
};
