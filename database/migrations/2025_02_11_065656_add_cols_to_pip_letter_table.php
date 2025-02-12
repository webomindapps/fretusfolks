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
        Schema::table('pip_letter', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('pip_letter_path')->nullable()->after('date_of_update');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pip_letter', function (Blueprint $table) {
            $table->dropColumn('pip_letter_path', 'created_at', 'updated_at');
        });
    }
};
