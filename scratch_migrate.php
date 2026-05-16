<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (App\Models\Blog::all() as $b) {
    if (is_string($b->tags)) $b->tags = json_decode($b->tags, true);
    if (is_string($b->liked_by)) $b->liked_by = json_decode($b->liked_by, true);
    $b->save();
}
echo "Done!\n";
