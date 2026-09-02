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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'original_price')) {
                $table->decimal('original_price', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('products', 'discount_percent')) {
                $table->integer('discount_percent')->nullable();
            }
            if (!Schema::hasColumn('products', 'deal_coins')) {
                $table->integer('deal_coins')->default(10);
            }
            if (!Schema::hasColumn('products', 'badge')) {
                $table->string('badge')->nullable(); // e.g. "30% OFF", "POPULAR", "HOT DEAL"
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'discount_percent', 'deal_coins', 'badge']);
        });
    }
};
