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
        Schema::table('client_management', function (Blueprint $table) {
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary()->change();
            // $table->string('client_code');
            // $table->string('client_name');
            // $table->string('land_line');
            // $table->string('client_email');
            // $table->string('contact_person');
            // $table->string('contact_person_phone');
            // $table->string('contact_person_email'); 
            // $table->string('contact_name_comm');
            // $table->string('contact_phone_comm');   
            // $table->string('contact_email_comm');
            // $table->text('registered_address');
            // $table->text('communication_address');
            // $table->string('pan');
            // $table->string('tan');
            $table->string('gstn')->nullable();
            // $table->string('website_url');
            // $table->string('mode_agreement');
            // $table->string('agreement_type');
            $table->string('other_agreement')->nullable();
            // $table->string('agreement_doc');
            // $table->string('region');
            // $table->integer('service_state ');
            // $table->date('contract_start');
            // $table->date('contract_end');
            // $table->string('rate');
            // $table->integer('commercial_type');
            // $table->text('remark');
            // $table->integer('status');
            // $table->string('modify_by');
            // $table->date('modify_date');
            // $table->integer('active_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {Schema::table('client_management', function (Blueprint $table) {
        $table->dropColumn(['created_at', 'updated_at']);
    });
    }
};
