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
        DB::table('offer_letter')
            ->where('joining_date', '0000-00-00')
            ->update(['joining_date' => null]);

        DB::table('offer_letter')
            ->where('tenure_date', '0000-00-00')
            ->update(['tenure_date' => null]);

        // Modify entity_name column
        Schema::table('offer_letter', function (Blueprint $table) {
            $table->text('entity_name')->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offer_letter', function (Blueprint $table) {
            //
        });
    }
};
