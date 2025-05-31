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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->tinyInteger('dashboard2')->default(0);
            $table->tinyInteger('search_client')->default(0);
            $table->tinyInteger('services')->default(0);
            $table->tinyInteger('search_token')->default(0);
            $table->tinyInteger('payments')->default(0);
            $table->tinyInteger('reports')->default(0);
            $table->tinyInteger('announcements')->default(0);
            $table->tinyInteger('team_users')->default(0);
            $table->tinyInteger('cms')->default(0);
          	$table->tinyInteger('reports')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
