<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('type')->default('shop')->after('slug'); // 'shop' or 'service'
            $table->json('services')->nullable()->after('about');   // list of services offered
            $table->string('service_area')->nullable()->after('services'); // e.g. "Kozhikode, 10km"
            $table->unsignedTinyInteger('experience_years')->nullable()->after('service_area');
            $table->string('availability')->nullable()->after('experience_years'); // e.g. "Mon–Sat, 9am–7pm"
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['type', 'services', 'service_area', 'experience_years', 'availability']);
        });
    }
};
