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
        Schema::table('ffi_increment_letter', function (Blueprint $table) {
            DB::statement('ALTER TABLE ffi_increment_letter ADD PRIMARY KEY (`id`);');
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->integer('company_id')->nullable()->change();
            $table->string('employee_id', 128)->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->integer('offer_letter_type')->nullable()->change();
            $table->integer('status')->nullable()->change();
            // $table->float('basic_salary');
            // $table->float('hra');
            // $table->float('conveyance');
            // $table->float('medical_reimbursement');
            // $table->float('special_allowance');
            // $table->float('other_allowance');
            // $table->float('st_bonus');
            // $table->float('gross_salary');
            // $table->float('pf_percentage');
            // $table->float('emp_pf');
            // $table->float('esic_percentage');
            // $table->float('emp_esic');
            // $table->float('pt');
            // $table->float('total_deduction');
            // $table->float('employer_pf_percentage');
            // $table->float('employer_pf');
            // $table->float('employer_esic_percentage');
            // $table->float('employer_esic');
            // $table->float('mediclaim');
            // $table->float('ctc');
            // $table->text('content');
            $table->date('effective_date')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('ffi_increment_letter');
    }
};
