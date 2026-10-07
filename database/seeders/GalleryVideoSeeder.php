<?php

namespace Database\Seeders;

use App\Models\GalleryVideo;
use Illuminate\Database\Seeder;

class GalleryVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Dokumenter Pesona Wisata & Pesisir Eksotis Negeri Morela',
                'slug' => 'pesona-pesisir-eksotis-morela',
                'description' => 'Menyusuri keindahan panorama Pantai Lubang Buaya, tebing karang Lawalata, dan kekayaan terumbu karang Leihitu.',
                'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-a-beach-with-turquoise-water-41221-large.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80',
                'duration' => '03:45',
                'file_size_mb' => 128.5,
                'category' => 'alam',
                'author' => 'Tim Dokumentasi KKN UNIDAR',
                'is_published' => true,
            ],
            [
                'title' => 'Prosesi Adat Sakral Tradisi Pukul Sapu Lidi 7 Syawal',
                'slug' => 'prosesi-adat-pukul-sapu-morela',
                'description' => 'Liputan ritual tahunan pemuda Morela memperingati perjuangan Kapahaha dengan ketahanan fisik, zikir, dan minyak mamala.',
                'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-traditional-cultural-ceremony-with-dancers-42861-large.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=1000&q=80',
                'duration' => '06:20',
                'file_size_mb' => 245.0,
                'category' => 'budaya',
                'author' => 'Pokdarwis & Tetua Adat Morela',
                'is_published' => true,
            ],
            [
                'title' => 'Geliat UMKM: Penyulingan Minyak Kayu Putih Alami',
                'slug' => 'penyulingan-minyak-kayu-putih-morela',
                'description' => 'Melihat langsung proses petik daun cajuput hingga penyulingan ketel uap tradisional menghasilkan minyak kayu putih murni.',
                'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-steam-rising-from-a-hot-spring-water-surface-42981-large.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=800&q=80',
                'duration' => '04:10',
                'file_size_mb' => 180.2,
                'category' => 'umkm',
                'author' => 'Kelompok Tani Penyuling Morela',
                'is_published' => true,
            ],
            [
                'title' => 'Video Profil Program Pengabdian Mahasiswa UNIDAR di Leihitu',
                'slug' => 'profil-pengabdian-kkn-unidar-morela',
                'description' => 'Rangkuman kegiatan mahasiswa KKN UNIDAR dalam pemetaan potensi wisata, perancangan portal digital, edukasi e-ticketing QRIS, dan pelatihan kemasan UMKM.',
                'video_url' => 'https://assets.mixkit.co/videos/preview/mixkit-students-working-together-in-a-classroom-43180-large.mp4',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=1000&q=80',
                'duration' => '05:15',
                'file_size_mb' => 312.4,
                'category' => 'pengabdian',
                'author' => 'DPL & Mahasiswa UNIDAR Ambon',
                'is_published' => true,
            ],
        ];

        foreach ($videos as $v) {
            GalleryVideo::updateOrCreate(['slug' => $v['slug']], $v);
        }
    }
}
