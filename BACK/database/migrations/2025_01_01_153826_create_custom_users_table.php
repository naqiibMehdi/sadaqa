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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('first_name', 255);
            $table->string('public_name', 255);
            $table->date('birth_date');
            $table->string('email')->unique();
            $table->string('password');
            $table->dateTime('subscribe_date');
            $table->string('img_profile', 255);
            $table->foreignId("id_address")->constrained("addresses");
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
