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
        Schema::create('company_profiles', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('address');
            $table->text('home_description')->nullable();
            $table->text('about_description')->nullable();
            $table->string('img_home');
            $table->string('img_description');
            $table->string('phone', 20);
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
