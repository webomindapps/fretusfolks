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
        Schema::table('show_cause', function (Blueprint $table) {
            DB::statement('ALTER TABLE show_cause ADD PRIMARY KEY (`id`);');
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('showcause_letter_path')->after('date_of_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('show_cause', function (Blueprint $table) {
            $table->dropColumn('showcause_letter_path', 'created_at', 'updated_at');
        });
    }
};
