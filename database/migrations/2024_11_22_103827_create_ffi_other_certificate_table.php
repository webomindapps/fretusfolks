<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ffi_other_certificate', function (Blueprint $table) {
            // DB::statement('ALTER TABLE ffi_other_certificate ADD PRIMARY KEY (`id`);');
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('emp_id', 100)->nullable()->change();
            $table->string('path', 100)->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ffi_other_certificate', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }

};
