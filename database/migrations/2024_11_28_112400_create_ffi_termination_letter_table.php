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
        Schema::table('ffi_termination_letter', function (Blueprint $table) {
            // DB::statement('ALTER TABLE ffi_termination_letter ADD PRIMARY KEY (`id`);');
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('emp_id')->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->date('absent_date')->nullable()->change();
            $table->date('show_cause_date')->nullable()->change();
            $table->date('termination_date')->nullable()->change();
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
        // Schema::dropIfExists('ffi_termination_letter');
    }
};
