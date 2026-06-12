<?php
$p = App\Models\Property::first();
if ($p) {
    App\Models\PropertyImage::create([
        'property_id' => $p->id,
        'path' => 'test/path.jpg',
        'order' => 1
    ]);
    echo "Created PropertyImage\n";
} else {
    echo "No Property found\n";
}
