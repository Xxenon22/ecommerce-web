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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->nullable()->after('id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('expedition_id')->constrained('expeditions')->onDelete('cascade');
            $table->integer('expedition_price')->default(0);
            $table->integer('total_price');
            $table->foreignId('address_id')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
