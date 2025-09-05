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
        Schema::table('offer_letter', function (Blueprint $table) {
            $table->string('employer_lwf')->nullable()->after('employer_esic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_letter', function (Blueprint $table) {
            $table->dropColumn('employer_lwf');
        });
    }
};
