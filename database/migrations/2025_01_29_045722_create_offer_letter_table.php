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
        Schema::table('offer_letter', function (Blueprint $table) {
            DB::statement('ALTER TABLE offer_letter ADD PRIMARY KEY (`id`);');
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->integer('company_id')->nullable()->change();
            $table->string('employee_id', 128)->nullable()->change();
            $table->string('emp_name', 30)->nullable()->change();
            $table->string('phone1', 20)->nullable()->change();
            $table->string('entity_name', 50)->nullable()->change();
            $table->date('joining_date')->nullable()->change();
            $table->string('location', 30)->nullable()->change();
            $table->string('department', 30)->nullable()->change();
            $table->string('father_name', 30)->nullable()->change();
            $table->string('tenure_month', 30)->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->date('tenure_date')->nullable()->change();
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
            $table->float('emp_pf')->nullable()->change();
            $table->float('emp_esic')->nullable()->change();
            $table->float('pt')->nullable()->change();
            $table->float('total_deduction')->nullable()->change();
            $table->float('take_home')->nullable()->change();
            $table->float('employer_pf')->nullable()->change();
            $table->float('employer_esic')->nullable()->change();
            $table->float('mediclaim')->nullable()->change();
            $table->float('ctc')->nullable()->change();
            $table->integer('leave_wage')->nullable()->change();
            $table->string('email', 50)->nullable()->change();
            $table->integer('notice_period')->default(7)->nullable()->change();
            $table->integer('salary_date')->default(7)->nullable()->change();
            $table->string('designation', 30)->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_letter');
    }
};
