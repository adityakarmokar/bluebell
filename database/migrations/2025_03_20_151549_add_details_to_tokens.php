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
        Schema::table('tokens', function (Blueprint $table) {
            $table->double('refund_amount')->nullable()->after('filed_document');
            $table->double('payable_amount')->nullable()->after('refund_amount');
            $table->double('consultency_fees')->nullable()->after('payable_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tokens', function (Blueprint $table) {
            $table->dropColumn(['refund_amount', 'payable_amount', 'consultency_fees']);
        });
    }
};
