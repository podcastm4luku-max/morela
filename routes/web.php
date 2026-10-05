<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\CultureController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\GalleryVideoController;

/*
|--------------------------------------------------------------------------
| Web Routes - Morela Tourism Portal
| Program Pengabdian Universitas Darussalam Ambon & Desa Morela
|--------------------------------------------------------------------------
*/

// Public Frontend Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/tentang-morela', [HomeController::class, 'about'])->name('about');
Route::get('/pengabdian-unidar', [HomeController::class, 'unidar'])->name('program.unidar');

// Destinasi Wisata
Route::get('/destinasi', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinasi/{slug}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/destinasi/{slug}/qr', [DestinationController::class, 'qrCode'])->name('destinations.qr');

// Sistem E-Ticketing & Pembayaran
Route::get('/tiket-wisata', [TicketController::class, 'index'])->name('tickets.index');
Route::post('/tiket-wisata/pesan', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tiket-wisata/bayar/{booking_code}', [TicketController::class, 'payment'])->name('tickets.payment');
Route::post('/tiket-wisata/konfirmasi/{booking_code}', [TicketController::class, 'confirmPayment'])->name('tickets.confirm');
Route::get('/tiket-wisata/e-tiket/{booking_code}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('/tiket-wisata/cek', [TicketController::class, 'checkStatus'])->name('tickets.check');

// Budaya & Arsip Digital Morela
Route::get('/budaya', [CultureController::class, 'index'])->name('culture.index');
Route::get('/budaya/{slug}', [CultureController::class, 'show'])->name('culture.show');

// UMKM & Ekonomi Kreatif
Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{id}', [UmkmController::class, 'show'])->name('umkm.show');

// Peta Wisata "Explore Morela"
Route::get('/peta-wisata', [HomeController::class, 'map'])->name('map.index');

// Agenda & Warta Desa
Route::get('/agenda', [EventController::class, 'index'])->name('events.index');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

// Galeri Foto
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');

// 🔐 Dashboard Admin (Pemerintah Desa & Mahasiswa UNIDAR)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Destinasi
    Route::resource('destinations', DestinationController::class)->except(['index', 'show']);
    
    // Kelola E-Tiket & Check-In Loket
    Route::get('/tiket', [AdminController::class, 'tickets'])->name('tickets.index');
    Route::post('/tiket/check-in', [AdminController::class, 'checkIn'])->name('tickets.checkin');
    Route::patch('/tiket/{id}/status', [AdminController::class, 'updateTicketStatus'])->name('tickets.status');
    
    // CRUD UMKM, Berita, Agenda, Budaya, Galeri
    Route::resource('umkm', UmkmController::class)->except(['index', 'show']);
    Route::resource('news', NewsController::class)->except(['index', 'show']);
    Route::resource('events', EventController::class)->except(['index', 'show']);
    Route::resource('culture', CultureController::class)->except(['index', 'show']);
    Route::resource('gallery', GalleryController::class)->except(['index', 'show']);
    
    // CRUD Media Sosial Desa (Promosi & Kontak Resmi)
    Route::resource('social-media', SocialMediaController::class);
    Route::patch('/social-media/{id}/toggle-status', [SocialMediaController::class, 'toggleStatus'])->name('social-media.toggle');

    // CRUD Video Galeri (Maksimal 500MB)
    Route::resource('gallery-videos', GalleryVideoController::class);
});
