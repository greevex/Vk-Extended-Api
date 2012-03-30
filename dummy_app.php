<?php

require __DIR__ . '/vk_extended_api.inc.php';

/**
 * @var VEA\lib\wrapper\vk
 * @see VEA\lib\wrapper\vkConnection
 */
$vk = new VEA\lib\wrapper\vk(2822067, 'BBGlfgwaXu2Na104tdv4');

$data = parse_ini_file(__DIR__ . '/vea_config.ini');
$vk->loadConfig($data);

// HTTP
$vk->switchToHttp();

$data1 = $vk->wall->get(array('owner_id' => 1881722));

/*
// SSL
$vk->switchToSsl();
$vk->setScope(array(
    \VEA\lib\wrapper\vkConnection::SCOPE_FRIENDS,
    \VEA\lib\wrapper\vkConnection::SCOPE_ADV_WALL,
));
$vk->authorize();
$data2 = $vk->api('wall.get', array(
    'owner_id' => '1,1881722',  // Pavel Durov | Wall
    'count' => 2                // Limit posts
));

print "Comparing results...Is same? > " .
        (count(array_diff($data1, $data2)) === 0 ? 'yes' : 'no') . "\n";
print "Printing #1:\n" . print_r($data1, true);
print "Printing #2:\n" . print_r($data2, true);
*/

print "Printing #1:\n" . print_r($data1, true);
