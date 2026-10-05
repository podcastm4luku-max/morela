<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fitur Peta Wisata - Tabel Pivot Rute dan Destinasi yang Dilewati
     */
    public function up(): void
    {
        Schema::create('tourist_route_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tourist_route_id')->constrained('tourist_routes')->onDelete('cascade');
            $table->foreignId('tourist_destination_id')->constrained('tourist_destinations')->onDelete('cascade');
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_route_destinations');
    }
};
