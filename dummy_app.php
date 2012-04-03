<?php
require __DIR__ . '/vk_extended_api.inc.php';

$vk = new VEA\lib\vk(2822067, 'BBGlfgwaXu2Na104tdv4');

$vk->loadConfig(parse_ini_file(__DIR__ . '/vea_config.ini'));
$vk->switchToHttp();

$data = $vk->newsfeed->search(array(
    'q' => 'вечер',
    'count' => 20,
    'extended' => 1,
    'start_time' => $last_time
));