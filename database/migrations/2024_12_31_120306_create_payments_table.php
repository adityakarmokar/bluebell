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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('token_id')->nullable();
          	$table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_type')->nullable()->comment('By Online, By Cash');
            $table->string('order_id')->unique()->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->longText('gateway_response')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('refund_status')->default('not_requested');
            $table->timestamp('refund_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
