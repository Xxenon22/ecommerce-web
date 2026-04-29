<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyimpan setiap update status pengiriman dari webhook Biteship.
     * Setiap baris = satu event / checkpoint pengiriman.
     */
    public function up(): void
    {
        Schema::create('shipment_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');

            // Status dari Biteship (raw) dan yang sudah di-mapping
            $table->string('biteship_status')->nullable();   // e.g. "picking_up"
            $table->string('mapped_status')->nullable();     // e.g. "Kurir Menuju Pickup"

            // Deskripsi / pesan dari Biteship (jika ada di payload)
            $table->text('note')->nullable();

            // Link tracking kurir (courier_link dari Biteship)
            $table->string('courier_link')->nullable();

            // Waktu event diterima dari webhook
            $table->timestamp('event_time')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_trackings');
    }
};
