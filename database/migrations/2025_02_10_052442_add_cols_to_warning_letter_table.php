<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('warning_letter', function (Blueprint $table) {
            // DB::statement('ALTER TABLE warning_letter ADD PRIMARY KEY (`id`);');
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            // DB::statement("UPDATE warning_letter SET date = NULL WHERE date = '0000-00-00'");
            // DB::statement("UPDATE warning_letter SET date_of_update = NULL WHERE date_of_update = '0000-00-00'");

            $table->string('warning_letter_path')->after('date_of_update')->nullable();
            $table->string('content')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warning_letter', function (Blueprint $table) {
            $table->dropColumn('warning_letter_path', 'created_at', 'updated_at');
        });
    }
};
