<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('resi')->unique()->index();
            // Sender
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->string('sender_address');
            $table->string('sender_province');
            $table->string('sender_city');
            $table->string('sender_district');
            $table->string('sender_village');
            $table->string('sender_postal_code');
            // Receiver
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->string('receiver_address');
            $table->string('receiver_province');
            $table->string('receiver_city');
            $table->string('receiver_district');
            $table->string('receiver_village');
            $table->string('receiver_postal_code');
            // Package
            $table->decimal('weight', 8, 2);
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('reff_no')->nullable();
            $table->integer('koli')->default(1);
            $table->integer('price_per_kg');
            $table->integer('total_shipping');
            // Payment
            $table->enum('payment_method', ['Cash', 'Tagihan'])->default('Cash');
            $table->enum('payment_status', ['Lunas', 'Tagihan'])->default('Lunas');
            $table->text('billing_notes')->nullable();
            // Status
            $table->string('current_status')->default('Pending');
            // POD
            $table->string('pod_photo')->nullable();
            $table->string('pod_signature')->nullable();
            $table->string('pod_receiver_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
