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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('doc_type')->nullable();
            $table->text('form_16_a')->nullable();
            $table->text('annex_use')->nullable();
            $table->text('form_16_parantal')->nullable();
            $table->text('inv_lic_mf')->nullable();
            $table->text('intrest_certificate')->nullable();
            $table->text('public_investment')->nullable();
            $table->text('bank_statement')->nullable();
            $table->text('sales_purchase')->nullable();
            $table->text('comment')->nullable();
            $table->string('action_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};
