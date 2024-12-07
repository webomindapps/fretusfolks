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
        Schema::table('ffi_offer_letter', function (Blueprint $table) {
            // DB::statement('ALTER TABLE ffi_offer_letter ADD PRIMARY KEY (`id`);');
            // $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->string('employee_id', 128)->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->integer('offer_letter_type')->nullable()->change();
            $table->integer('status')->nullable()->change();
            $table->float('basic_salary')->nullable()->change();
            $table->float('hra')->nullable()->change();
            $table->float('conveyance')->nullable()->change();
            $table->float('medical_reimbursement')->nullable()->change();
            $table->float('special_allowance')->nullable()->change();
            $table->float('other_allowance')->nullable()->change();
            $table->float('st_bonus')->nullable()->change();
            $table->float('gross_salary')->nullable()->change();
            $table->float('pf_percentage')->nullable()->change();
            $table->float('emp_pf')->nullable()->change();
            $table->float('esic_percentage')->nullable()->change();
            $table->float('emp_esic')->nullable()->change();
            $table->float('pt')->nullable()->change();
            $table->float('total_deduction')->nullable()->change();
            $table->float('employer_pf_percentage')->nullable()->change();
            $table->float('employer_pf')->nullable()->change();
            $table->float('employer_esic_percentage')->nullable()->change();
            $table->float('employer_esic')->nullable()->change();
            $table->float('mediclaim')->nullable()->change();
            $table->float('ctc')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('ffi_offer_letter');
    }
};
