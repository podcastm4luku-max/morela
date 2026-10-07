<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$video = \App\Models\GalleryVideo::first();
if ($video) {
    echo 'Found: ' . $video->id . PHP_EOL;
    $video->delete();
    echo 'After delete: ' . (\App\Models\GalleryVideo::find($video->id) ? 'Found' : 'Not found') . PHP_EOL;
} else {
    echo 'No videos';
}
