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
        Schema::create('business_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Migrate data
        $businesses = DB::table('businesses')->whereNotNull('category_id')->get();
        foreach ($businesses as $business) {
            DB::table('business_categories')->insert([
                'business_id' => $business->id,
                'category_id' => $business->category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('businesses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        });

        // Reverse data migration
        $pivotData = DB::table('business_categories')->get();
        foreach ($pivotData as $data) {
            DB::table('businesses')->where('id', $data->business_id)->update([
                'category_id' => $data->category_id
            ]);
        }

        Schema::dropIfExists('business_categories');
    }
};
