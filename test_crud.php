<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\GalleryVideo;
use Illuminate\Support\Str;

echo "--- PHASE F: RUNTIME CREATE TEST ---\n";
$testTitle = 'CRUD_TEST_017_CREATE_' . time();
echo "Creating video with title: $testTitle\n";

$video = GalleryVideo::create([
    'title' => $testTitle,
    'slug' => Str::slug($testTitle).'-'.Str::random(5),
    'category' => 'wisata',
    'description' => 'Test description',
    'duration' => '01:00',
    'file_size_mb' => 10,
    'author' => 'Tester',
    'video_url' => '/storage/videos/test.mp4',
    'is_published' => true,
]);

echo "Create Status: " . ($video ? "Success" : "Failed") . "\n";
echo "Created ID: " . $video->id . "\n";

echo "\n--- PHASE G: RUNTIME READ TEST ---\n";
$readVideo = GalleryVideo::where('title', $testTitle)->first();
echo "Read Status: " . ($readVideo ? "Found" : "Not Found") . "\n";
if ($readVideo) {
    echo "ID: {$readVideo->id}\n";
    echo "Slug: {$readVideo->slug}\n";
}

echo "\n--- PHASE 12: RUNTIME UPDATE TEST ---\n";
if ($readVideo) {
    $beforeUpdate = $readVideo->updated_at;
    echo "Before Update - Title: {$readVideo->title}\n";
    echo "Before Update - Updated At: {$beforeUpdate}\n";
    
    // Simulate slight delay
    sleep(1);
    
    $updateTitle = 'CRUD_TEST_017_UPDATE_' . time();
    $readVideo->title = $updateTitle;
    $readVideo->save();
    
    $afterUpdateVideo = GalleryVideo::find($readVideo->id);
    echo "After Update - Title: {$afterUpdateVideo->title}\n";
    echo "After Update - Updated At: {$afterUpdateVideo->updated_at}\n";
}

echo "\n--- PHASE 16: RUNTIME DELETE TEST ---\n";
if (isset($afterUpdateVideo) && $afterUpdateVideo) {
    $idToDelete = $afterUpdateVideo->id;
    echo "Deleting ID: {$idToDelete}\n";
    $afterUpdateVideo->delete();
    
    $checkDeleted = GalleryVideo::find($idToDelete);
    echo "Delete Status: " . ($checkDeleted ? "Failed (Still exists)" : "Success (Not found)") . "\n";
}

echo "\n--- PHASE 25: CLEANUP ---\n";
$count = GalleryVideo::where('title', 'LIKE', 'CRUD_TEST_017_%')->delete();
echo "Cleanup deleted $count remaining test rows.\n";
