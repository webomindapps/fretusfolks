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
        Schema::table('cms_pf', function (Blueprint $table) {
            DB::statement('ALTER TABLE cms_pf ADD PRIMARY KEY (`id`);');
            $table->bigInteger('id')->unsigned()->autoIncrement()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('c_m_s_p_f_s');
    }
};
