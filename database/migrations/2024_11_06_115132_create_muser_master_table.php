<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('muser_master', function (Blueprint $table) {
            // $table->id();
            // $table->string('emp_id');
            // $table->string('name');
            // $table->string('email');
            // $table->string('username');
            // $table->string('password');
            // $table->string('enc_pass');
            // $table->integer('user_type');
            // $table->integer('status');
            // $table->date('date');
            // $table->string('ref_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muser_master');
    }
};
