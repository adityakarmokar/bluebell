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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('f_fname')->nullable();
            $table->string('f_mname')->nullable();
            $table->string('f_lname')->nullable();
            $table->bigInteger('phone')->nullable();
            $table->bigInteger('mobile')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('pan_no')->nullable();
            $table->date('dob')->nullable();
            $table->string('adhar_number')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->string('otp')->nullable();
            $table->dateTime('otp_expires_at')->nullable();
            $table->string('user_token')->nullable();
            $table->string('password')->nullable();
            $table->string('action_by')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
