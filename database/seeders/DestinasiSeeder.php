<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinasiSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'slug' => 'pantai-lubang-buaya-morela',
                'name' => 'Pantai Lubang Buaya Morela',
                'category' => 'pantai',
                'tagline' => 'Perairan toska sebening kaca dan tebing karang alami berongga spektakuler',
                'description' => 'Lubang Buaya Morela bukan sekadar pantai biasa. Kawasan ini dinamakan demikian karena struktur batu karang raksasa purba yang membentuk celah menyerupai moncong buaya bila dilihat dari sudut tertentu. Perairan di sini sangat tenang, dilindungi oleh kontur teluk alami dengan gradasi warna air dari bening kristal, hijau toska, hingga biru tua di palung yang lebih dalam.',
                'location' => 'Bukit Lawalata, Sektor Selatan Morela',
                'latitude' => '-3.5910',
                'longitude' => '128.0750',
                'visiting_hours' => '05.30 - 19.00 WIT',
                'ticket_price' => 5000,
                'image_url' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1200&q=80',
                'published' => true,
                'featured' => false,
            ],
            [
                'slug' => 'benteng-kapahaha-sejarah',
                'name' => 'Benteng Kapahaha',
                'category' => 'religi_sejarah',
                'tagline' => 'Benteng alam pertahanan heroik Kapitan Telukabessy melawan penjajah',
                'description' => 'Benteng Kapahaha adalah saksi bisu heroisme perjuangan rakyat Leihitu, Maluku pada abad ke-17. Benteng ini bukanlah bangunan buatan manusia, melainkan benteng alam berupa bukit karang terjal yang tidak tertembus meriam VOC selama bertahun-tahun. Perang Kapahaha (1636-1646) yang dipimpin Kapitan Telukabessy menjadi simbol perlawanan tanpa kenal menyerah.',
                'location' => 'Perbukitan Kapahaha, Jalur Hutan Morela',
                'latitude' => '-3.5780',
                'longitude' => '128.0900',
                'visiting_hours' => '07.00 - 17.00 WIT',
                'ticket_price' => 0,
                'image_url' => 'https://images.unsplash.com/photo-1596700688647-197e4125b29c?auto=format&fit=crop&w=1200&q=80',
                'published' => true,
                'featured' => false,
            ],
            [
                'slug' => 'tanjung-nusanive-morela',
                'name' => 'Tanjung Nusanive',
                'category' => 'pemandangan',
                'tagline' => 'Tanjung elok untuk menikmati panorama laut banda dan perahu nelayan',
                'description' => 'Tanjung Nusanive adalah semenanjung kecil yang menjorok ke perairan Banda. Di sore hari, ini adalah spot terbaik untuk menyaksikan nelayan tradisional yang baru pulang melaut dengan perahu semang (cadik).',
                'location' => 'Ujung Tanjung, Pesisir Utara',
                'latitude' => '-3.5850',
                'longitude' => '128.0820',
                'visiting_hours' => '24 Jam (Terbuka untuk Umum)',
                'ticket_price' => 0,
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'published' => true,
                'featured' => true,
            ],
        ];

        foreach ($destinations as $d) {
            Destination::updateOrCreate(['slug' => $d['slug']], $d);
        }
    }
}
