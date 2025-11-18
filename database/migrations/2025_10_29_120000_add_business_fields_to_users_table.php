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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('business_type', ['restaurant', 'cafe', 'food_truck', 'other'])->nullable()->after('photo');
            $table->text('description')->nullable()->after('business_type');
            $table->string('opening_hours')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['business_type', 'description', 'opening_hours']);
        });
    }
};
