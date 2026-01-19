<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Http\Kernel::class);

use App\Models\Service;

$services = Service::select('id', 'name', 'image')->limit(5)->get();

echo "Total Services: " . count($services) . "\n\n";
foreach ($services as $s) {
    echo "ID: {$s->id}, Name: {$s->name}, Image: {$s->image}\n";
}
?>
