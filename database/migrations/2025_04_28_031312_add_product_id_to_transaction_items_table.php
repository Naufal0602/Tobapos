<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transaction_items', 'product_id')) {
            Schema::table('transaction_items', function (Blueprint $table) {
                $table->foreignId('product_id')->constrained()->after('transaction_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('transaction_items', 'product_id')) {
            Schema::table('transaction_items', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }
    }
};
