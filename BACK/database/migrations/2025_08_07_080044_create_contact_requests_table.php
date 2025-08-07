<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('contact_requests', function (Blueprint $table) {
      $table->id();
      $table->string('email');
      $table->text('description');
      $table->enum('status', ['pending', 'processed'])->default('pending');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('contact_requests');
  }
};
