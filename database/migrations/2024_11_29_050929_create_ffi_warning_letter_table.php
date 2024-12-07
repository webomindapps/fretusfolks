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
        Schema::table('ffi_warning_letter', function (Blueprint $table) {
            // DB::statement('ALTER TABLE ffi_warning_letter ADD PRIMARY KEY (`id`);');
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('emp_id')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->text('content')->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->date('date_of_update')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('ffi_warning_letter');
    }
};
