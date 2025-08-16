<?php

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('campaign_recoveries', function (Blueprint $table) {
      $table->id();
      $table->foreignIdFor(Campaign::class)->nullable()->constrained()->nullOnDelete();
      $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
      $table->unsignedInteger('amount');
      $table->unsignedInteger('amount_assoc');
      $table->unsignedInteger('total_amount');
      $table->enum('status', ['pending', 'processed', 'failed'])->default('pending');
      $table->text("iban");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('campaign_recoveries');
  }
};
