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
    Schema::table('campaigns', function (Blueprint $table) {
      $table->dateTime('closing_date')->nullable()->default(null)->change();
      $table->boolean('is_anonymous')->default(false)->after('closing_date');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('campaigns', function (Blueprint $table) {
      $table->dateTime('closing_date')->nullable()->change();
      $table->dropColumn('is_anonymous');
    });
  }
};
