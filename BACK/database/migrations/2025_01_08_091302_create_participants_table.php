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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("first_name");
            $table->string("email");
            $table->unsignedInteger("amount");
            $table->timestamp("participation_date")->useCurrent();
            $table->unsignedBigInteger("campaign_id");
            $table->foreign("campaign_id")->references("id")->on("campaigns")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
