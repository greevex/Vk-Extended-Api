<?php
require __DIR__ . '/vk_extended_api.inc.php';

$vk = new VEA\lib\wrapper\vk(2822067, 'BBGlfgwaXu2Na104tdv4');
$data1 = $vk->api('wall.get', array(
    'owner_id' => 1,    // Pavel Durov | Wall
    'count' => 2        // Limit posts
));
print_r($data1);