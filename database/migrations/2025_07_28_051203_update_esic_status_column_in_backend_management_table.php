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
            $table->renameColumn('esic_status', 'other_deduction');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backend_management', function (Blueprint $table) {
            $table->dropColumn('other_deduction');
        });
    }
};
