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
        Schema::table('client_management', function (Blueprint $table) {
            $table->string('client_ffi_id')->after('client_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_management', function (Blueprint $table) {
            $table->dropcolumn('client_ffi_id');

        });
    }
};
