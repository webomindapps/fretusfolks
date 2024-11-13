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
        Schema::table('client_gstn', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            // $table->string('client_id');
            // $table->unsignedBigInteger('state')->after('client_id');
            // $table->string('gstn_no');
            // $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_gstn', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
        });
    }
};
