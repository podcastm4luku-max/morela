<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel Galeri Video Dokumentasi (Maksimal 500MB per file)
     */
    public function up(): void
    {
        Schema::create('gallery_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');                           // Judul video dokumentasi
            $table->string('slug')->unique();                 // Slug unik video
            $table->text('description')->nullable();          // Deskripsi video
            $table->string('video_url');                      // Path penyimpanan file lokal atau URL video streaming
            $table->string('thumbnail_url')->nullable();      // Foto thumbnail / cover video
            $table->string('duration')->nullable();           // Durasi video, misal: '04:15'
            $table->decimal('file_size_mb', 8, 2)->default(0); // Ukuran berkas dalam MB (Maks. 500 MB)
            $table->string('category')->default('wisata');    // Kategori: alam, budaya, wisata, umkm, pengabdian
            $table->string('author')->nullable();             // Pengunggah / Tim pembuat
            $table->boolean('is_published')->default(true);   // Status tayang publik
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_videos');
    }
};
