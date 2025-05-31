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
        Schema::create('token_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('token_id')->nullable();
            $table->bigInteger('service_id')->nullable();
            $table->string('year')->nullable();
            $table->string('doc_type')->nullable();
            $table->text('form_16_a')->nullable();
            $table->text('annex_use')->nullable();
            $table->text('form_16_parantal')->nullable();
            $table->text('inv_lic_mf')->nullable();
            $table->text('intrest_certificate')->nullable();
            $table->text('public_investment')->nullable();
            $table->text('bank_statement')->nullable();
            $table->text('sales_purchase')->nullable();
            $table->text('additional_documents')->nullable();
            $table->text('comment')->nullable();
            $table->string('action_by')->nullable();            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_documents');
    }
};
