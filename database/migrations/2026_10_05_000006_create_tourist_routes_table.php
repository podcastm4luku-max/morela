<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fitur Peta Wisata & Jelajah Negeri Morela - Tabel Rute Perjalanan Wisata
     */
    public function up(): void
    {
        Schema::create('tourist_routes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('start_name');
            $table->decimal('start_latitude', 10, 7);
            $table->decimal('start_longitude', 11, 7);
            $table->string('end_name');
            $table->decimal('end_latitude', 10, 7);
            $table->decimal('end_longitude', 11, 7);
            $table->string('distance')->nullable();
            $table->string('duration')->nullable();
            $table->text('google_maps_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_routes');
    }
};
