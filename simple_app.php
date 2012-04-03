<?php
require __DIR__ . '/vk_extended_api.inc.php';

$vk = new VEA\lib\vk(2822067, 'BBGlfgwaXu2Na104tdv4');

/**
 * PHP5.4 code seems like this:
 * $data1 = $vk->wall->get(['owner_id'=>1,'count'=>2]);
 */
$data = $vk->wall->get(array('owner_id' => 1, 'count' => 2));

print_r($data);