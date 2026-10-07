<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socials = [
            [
                'name' => 'Instagram',
                'slug' => 'instagram',
                'icon' => 'instagram',
                'url' => 'https://instagram.com/morelatourism',
                'username' => '@morelatourism',
                'description' => 'Dokumentasi visual keindahan alam, agenda atraksi adat, dan update terkini Negeri Morela.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Facebook',
                'slug' => 'facebook',
                'icon' => 'facebook',
                'url' => 'https://facebook.com/morelatourismofficial',
                'username' => 'Morela Tourism Official',
                'description' => 'Halaman resmi komunitas warga, diaspora Maluku, dan publikasi warta kegiatan desa.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'YouTube',
                'slug' => 'youtube',
                'icon' => 'youtube',
                'url' => 'https://youtube.com/@morelatourism',
                'username' => 'Morela Tourism Maluku',
                'description' => 'Video dokumenter tradisi Pukul Sapu, profil UMKM, dan panorama pesisir Leihitu.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'TikTok',
                'slug' => 'tiktok',
                'icon' => 'tiktok',
                'url' => 'https://tiktok.com/@pesona_morela',
                'username' => '@pesona_morela',
                'description' => 'Konten video kreatif pendek seputar spot snorkeling, kuliner, dan pesona alam Morela.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'WhatsApp',
                'slug' => 'whatsapp',
                'icon' => 'whatsapp',
                'url' => 'https://wa.me/6281234567800',
                'username' => '+62 812-3456-7800',
                'description' => 'Layanan informasi wisata, reservasi grup, dan panduan langsung Pokdarwis Desa Morela.',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'X (Twitter)',
                'slug' => 'x',
                'icon' => 'twitter',
                'url' => 'https://x.com/MorelaTourism',
                'username' => '@MorelaTourism',
                'description' => 'Siaran cepat kabar cuaca laut, jadwal atraksi festival, dan pengumuman desa.',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Telegram',
                'slug' => 'telegram',
                'icon' => 'telegram',
                'url' => 'https://t.me/morelatourism',
                'username' => '@morelatourism',
                'description' => 'Kanal siaran warta berkala dan arsip publikasi kebudayaan desa.',
                'is_active' => false,
                'sort_order' => 7,
            ],
        ];

        foreach ($socials as $item) {
            SocialMedia::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
