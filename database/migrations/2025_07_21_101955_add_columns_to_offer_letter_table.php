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
            $table->string('gender_salutation')->nullable()->after('employer_esic');
            $table->string('other_deduction')->nullable()->after('pt');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_letter', function (Blueprint $table) {

            $table->dropColumn('gender_salutation');
            $table->dropColumn('other_deduction');
        });
    }
};
