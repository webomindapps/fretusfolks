<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('termination_letter', function (Blueprint $table) {
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();

            $table->string('termination_letter_path')->nullable()->after('date_of_update');
            $table->text('content')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('termination_letter', function (Blueprint $table) {
            $table->dropColumn('termination_letter_path', 'created_at', 'updated_at');
        });
    }
};
