<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('destination_id')->constrained('destinations')->cascadeOnDelete();
            $table->date('visit_date');
            $table->string('visitor_name');
            $table->string('visitor_phone');
            $table->string('visitor_email')->nullable();
            $table->string('visitor_city')->nullable();
            $table->unsignedInteger('adult_count')->default(1);
            $table->unsignedInteger('child_count')->default(0);
            $table->unsignedInteger('price_per_ticket')->default(5000);
            $table->unsignedInteger('cleanliness_fee')->default(2000);
            $table->unsignedInteger('total_amount');
            $table->enum('payment_method', ['qris', 'va_maluku', 'va_bca', 'va_mandiri', 'cash_on_site'])->default('qris');
            $table->enum('payment_status', ['pending', 'paid', 'checked_in', 'cancelled'])->default('pending');
            $table->string('qr_validation_code')->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_bookings');
    }
};
