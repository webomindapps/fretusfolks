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
        Schema::create('cms_clras', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('year')->nullable();
            $table->string('month')->nullable();
            $table->string('path')->nullable();
            $table->tinyInteger('status')->nullable(); // use integer if status is numeric, or string if text

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_clras');
    }
};
