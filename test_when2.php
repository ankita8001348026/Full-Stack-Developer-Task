<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$query = App\Models\Project::where('status', 1)->when(function ($query) {
    // return null
});
$count = $query->count();
echo "Type of count: " . (is_object($count) ? get_class($count) : gettype($count)) . "\n";
