<?php
use App\Models\Destination;
use App\Models\SocialMedia;
use App\Models\GalleryVideo;
use App\Models\TicketBooking;

// Test Destination
$d = Destination::create([
    'name'=>'Test Dest PHASE3_TEST', 
    'slug'=>'test-dest-phase3', 
    'category'=>'pantai',
    'tagline'=>'test',
    'image_url'=>'/test.jpg',
    'description'=>'Test', 
    'location'=>'Test', 
    'ticket_price'=>10000, 
    'published'=>true
]);
echo "Destination CREATE OK\n";
$d->update(['location'=>'Test Update']);
echo "Destination UPDATE OK\n";
$d_read = Destination::find($d->id);
echo $d_read ? "Destination SELECT OK\n" : "FAIL\n";

// Test SocialMedia
$s = SocialMedia::create(['name'=>'Test Social PHASE3_TEST', 'slug'=>'test-social-phase3', 'icon'=>'test', 'url'=>'http://test.com']);
echo "SocialMedia CREATE OK\n";
$s->update(['icon'=>'test-update']);
echo "SocialMedia UPDATE OK\n";
$s_read = SocialMedia::find($s->id);
echo $s_read ? "SocialMedia SELECT OK\n" : "FAIL\n";

// Test GalleryVideo
$g = GalleryVideo::create(['title'=>'Test Video PHASE3_TEST', 'slug'=>'test-video-phase3', 'youtube_id'=>'test', 'description'=>'Test']);
echo "GalleryVideo CREATE OK\n";
$g->update(['youtube_id'=>'test-update']);
echo "GalleryVideo UPDATE OK\n";
$g_read = GalleryVideo::find($g->id);
echo $g_read ? "GalleryVideo SELECT OK\n" : "FAIL\n";

// Test TicketBooking (depends on Destination)
$t = TicketBooking::create([
    'booking_code'=>'TEST-PHASE3', 
    'destination_id'=>$d->id, 
    'visit_date'=>'2026-10-10', 
    'visitor_name'=>'Test User', 
    'visitor_phone'=>'0812', 
    'visitor_email'=>'test@test.com',
    'adult_count'=>1, 
    'child_count'=>0,
    'price_per_ticket'=>10000, 
    'cleanliness_fee'=>2000, 
    'total_amount'=>12000, 
    'payment_method'=>'qris', 
    'payment_status'=>'pending', 
    'qr_validation_code'=>'TEST-QR'
]);
echo "TicketBooking CREATE OK\n";
$t->update(['payment_status'=>'paid']);
echo "TicketBooking UPDATE OK\n";
$t_read = TicketBooking::find($t->id);
echo $t_read ? "TicketBooking SELECT OK\n" : "FAIL\n";
