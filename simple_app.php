<?php
require __DIR__ . '/vk_extended_api.al.php';

$vk = new \vk\wrapper(2822067, 'BBGlfgwaXu2Na104tdv4');

$data = $vk->wall->get(array('owner_id' => 1, 'count' => 2));

print_r($data);