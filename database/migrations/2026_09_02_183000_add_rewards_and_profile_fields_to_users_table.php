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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'coins')) {
                $table->integer('coins')->default(10);
            }
            if (!Schema::hasColumn('users', 'credits')) {
                $table->decimal('credits', 10, 2)->default(250.00);
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_profile_completed')) {
                $table->boolean('is_profile_completed')->default(false);
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->boolean('is_verified')->default(true);
            }
        });

        if (!Schema::hasTable('saved_deals')) {
            Schema::create('saved_deals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('business_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
                $table->string('deal_title')->nullable();
                $table->string('type')->default('saved'); // 'saved', 'unlocked', 'booking'
                $table->integer('coins_used')->default(0);
                $table->string('status')->default('active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['coins', 'credits', 'avatar', 'is_profile_completed', 'is_verified']);
        });
        Schema::dropIfExists('saved_deals');
    }
};
