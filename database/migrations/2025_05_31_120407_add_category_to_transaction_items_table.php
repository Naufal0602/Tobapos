<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('transaction_items', function (Blueprint $table) {
        $table->string('category')->nullable(); // tipe string, bisa disesuaikan
    });
}

public function down()
{
    Schema::table('transaction_items', function (Blueprint $table) {
        $table->dropColumn('category');
    });
}

};
