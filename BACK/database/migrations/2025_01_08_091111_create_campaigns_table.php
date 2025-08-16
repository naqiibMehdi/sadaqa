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
    Schema::create('campaigns', function (Blueprint $table) {
      $table->id();
      $table->string("title");
      $table->text("description");
      $table->string("image")->nullable();
      $table->unsignedInteger("target_amount");
      $table->unsignedInteger("collected_amount")->default(0);
      $table->timestamp("created_at")->useCurrent();
      $table->unsignedBigInteger("category_id")->nullable();
      $table->unsignedBigInteger("user_id");
      $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
      $table->foreign("category_id")->references("id")->on("categories")->onDelete("set null");
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('campaigns');
  }
};
