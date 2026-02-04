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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('recipient_name');   // Nama Penerima
            $table->string('phone');            // Nomor Telepon
            $table->string('province');
            $table->string('city');
            $table->string('district');          // Kecamatan
            $table->string('postal_code');       // Kode Pos
            $table->text('address_detail');      // Alamat Detail

            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
