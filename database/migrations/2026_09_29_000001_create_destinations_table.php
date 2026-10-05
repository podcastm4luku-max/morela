<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->enum('category', ['pantai', 'alam', 'pemandangan', 'religi_sejarah', 'budaya']);
            $table->string('tagline');
            $table->string('tagline_en')->nullable();
            $table->text('description');
            $table->text('description_en')->nullable();
            $table->string('location');
            $table->decimal('latitude', 10, 7)->default(-3.5824);
            $table->decimal('longitude', 10, 7)->default(128.0842);
            $table->string('visiting_hours')->default('07.00 - 18.00 WIT');
            $table->unsignedInteger('ticket_price')->default(5000);
            $table->json('facilities')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('image_url');
            $table->json('gallery_images')->nullable();
            $table->boolean('featured')->default(true);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
