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
    Schema::create('pdf_downloads', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
      $table->enum('document_type', ['summary', 'invoice', 'receipt'])->default('invoice');
      $table->string('filename');
      $table->ipAddress('ip_address');
      $table->string('user_agent')->nullable();
      $table->timestamp('downloaded_at');
      $table->timestamps();

      // Index pour optimiser les requêtes
      $table->index(['user_id', 'campaign_id', 'document_type']);
      $table->index('downloaded_at');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pdf_downloads');
  }
};
