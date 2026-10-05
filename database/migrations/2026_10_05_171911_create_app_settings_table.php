<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default values
        DB::table('app_settings')->insert([
            ['key' => 'hero_title', 'value' => 'SELAMAT DATANG DI MORELA', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_subtitle', 'value' => '“Jelajah Pesona Morela – Alam, Budaya & Masyarakat”', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_description', 'value' => 'Temukan keindahan alam pesisir Leihitu, sakralnya tradisi Pukul Sapu, dan keramahan hangat masyarakat Negeri Morela, Maluku Tengah.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'hero_bg_image', 'value' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=85', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
