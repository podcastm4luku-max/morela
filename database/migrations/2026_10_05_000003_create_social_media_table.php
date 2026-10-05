<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fitur Media Sosial Morela Tourism
     */
    public function up(): void
    {
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // Nama platform: Instagram, Facebook, YouTube, TikTok, WhatsApp, X, Telegram
            $table->string('slug')->unique();            // Slug identifier: instagram, facebook, youtube, etc.
            $table->string('icon');                      // Nama icon / class (lucide, fontawesome, atau svg identifier)
            $table->string('url');                       // Tautan lengkap URL profil/chat
            $table->string('username')->nullable();      // Username / handle atau nomor telepon (+628...)
            $table->text('description')->nullable();     // Deskripsi fungsi kanal sosial media
            $table->boolean('is_active')->default(true); // Status aktif ditampilkan di website publik
            $table->unsignedInteger('sort_order')->default(0); // Urutan prioritas penataan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
