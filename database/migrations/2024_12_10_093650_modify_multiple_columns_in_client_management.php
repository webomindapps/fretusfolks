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
        Schema::table('client_management', function (Blueprint $table) {
            $table->string('region')->nullable()->change();
            $table->string('agreement_type')->nullable()->change();
            $table->integer('service_state')->nullable()->change();
            $table->date('contract_start')->nullable()->change();
            $table->date('contract_end')->nullable()->change();
            $table->string('rate')->nullable()->change();
            $table->integer('commercial_type')->nullable()->change();
            $table->text('remark')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('client_management', function (Blueprint $table) {
        //     //
        // });
    }
};
