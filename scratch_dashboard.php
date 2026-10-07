<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create('/admin/dashboard', 'GET');
$response = $kernel->handle($request);
echo "Dashboard Status: " . $response->getStatusCode() . "\n";
