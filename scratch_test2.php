<?php

use App\Models\TouristRoute;

$r = TouristRoute::create([
    'name' => 'Test Route',
    'slug' => 'test-route',
    'description' => 'Test',
    'difficulty_level' => 'mudah',
    'estimated_duration' => '2 Jam',
    'published' => true,
]);
echo $r->id ? "CREATE OK\n" : "FAIL\n";
$r->update(['name' => 'Test Update']);
echo $r->name == 'Test Update' ? "UPDATE OK\n" : "FAIL\n";
echo TouristRoute::find($r->id) ? "SELECT OK\n" : "FAIL\n";
$r->delete();
echo "CLEANED\n";
