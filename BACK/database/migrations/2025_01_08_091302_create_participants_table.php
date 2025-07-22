<?php

use App\Models\Campaign;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('participants', function (Blueprint $table) {
      $table->id();
      $table->string("name");
      $table->string("email");
      $table->unsignedInteger("amount");
      $table->timestamp("participation_date")->useCurrent();
      $table->string("payment_id")->nullable();
      $table->enum("payment_status", ["pending", "completed", "failed", "refunded", "cancelled"])->default("pending");
      $table->foreignIdFor(Campaign::class)->nullable()->constrained()->nullOnDelete();;
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
