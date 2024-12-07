<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cms_esic', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            // $table->unsignedBigInteger('state_id');
            // $table->unsignedBigInteger('client_id');
            // $table->string('year');
            // $table->string('month');
            // $table->string('path');
            // $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
