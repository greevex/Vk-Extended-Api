<?php
require __DIR__ . '/vk_extended_api.al.php';

new \vk\wrapper(2822067, 'BBGlfgwaXu2Na104tdv4');

$data = \vk\api\wall::get(1, 0, 2);
// also can use like
// $data = \vk\api\wall::get(array('owner_id' => 1, 'offset' => 0, 'count' => 2));

print_r($data);