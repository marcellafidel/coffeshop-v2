<?php
$dirs = [
    'resources/views/layouts',
    'resources/views/customer',
    'resources/views/admin',
    'resources/views/admin/products',
    'resources/views/admin/orders',
];

$from = ['#4A90D9', '#357ABD', '#f0f4ff', '#dce8fb', '#f0f7ff', '#c8d8e8', 'rgba(74,144,217,0.3)', 'rgba(74,144,217,0.15)', 'rgba(74,144,217,0.4)'];
$to   = ['#A8C8E8', '#8BB5D9', '#EFF6FF', '#D6EAF8', '#EFF6FF', '#B8D4E8', 'rgba(168,200,232,0.3)', 'rgba(168,200,232,0.15)', 'rgba(168,200,232,0.4)'];

$count = 0;
foreach ($dirs as $dir) {
    foreach (glob($dir . '/*.blade.php') as $file) {
        $content = file_get_contents($file);
        $new = str_replace($from, $to, $content);
        file_put_contents($file, $new);
        echo "Updated: $file\n";
        $count++;
    }
}
echo "\nDone! $count files updated.\n";