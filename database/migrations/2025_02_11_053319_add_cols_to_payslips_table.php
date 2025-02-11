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
        Schema::table('payslips', function (Blueprint $table) {
            DB::statement("UPDATE payslips SET date_upload = NULL WHERE date_upload = '0000-00-00'");
            // DB::statement('ALTER TABLE payslips ADD PRIMARY KEY (`id`);');
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('payslips_letter_path')->after('modify_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn('payslips_letter_path', 'created_at', 'updated_at');
        });
    }
};
