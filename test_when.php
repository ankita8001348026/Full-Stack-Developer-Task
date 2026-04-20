<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = new App\Models\User(); // Mock or something? 
// No, let's just test DB::table()->when...

use Illuminate\Database\Capsule\Manager as DB;
$query = App\Models\Project::where('status', 1)->when(function ($query) {
    // return null
});
echo "Type of query: " . get_class($query) . "\n";
$count = $query->count();
echo "Type of count result: " . gettype($count) . "\n";

$query2 = App\Models\Project::where('status', 1)->when(function ($query) {
    return $query->where('id', '>', 0);
});
$count2 = $query2->count();
echo "Type of count2 result: " . gettype($count2) . "\n";

