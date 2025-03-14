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
        Schema::table('increment_letter', function (Blueprint $table) {
            //  DB::statement('ALTER TABLE increment_letter ADD PRIMARY KEY (`id`);');
            DB::statement("UPDATE increment_letter SET effective_date = NULL WHERE effective_date = '0000-00-00'"); 
            //make nullable in database also
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('increment_path')->after('emp_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('increment_letter', function (Blueprint $table) {
            $table->dropColumn('increment_path','updated_at','created_at');

        });
    }
};
