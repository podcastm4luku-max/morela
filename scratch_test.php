<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/admin/gallery', 'GET');
$response = $kernel->handle($request);
echo "Gallery Headers:\n";
print_r($response->headers->all());

$request2 = Illuminate\Http\Request::create('/admin/gallery-videos', 'GET');
$response2 = $kernel->handle($request2);
echo "Gallery Videos Headers:\n";
print_r($response2->headers->all());
