<?php
$isCli = (PHP_SAPI == 'cli');

require __DIR__ . '/vk_extended_api.inc.php';

if(!$isCli) {
    print "<pre>\n";
}

$vk = new VEA\lib\wrapper\vk(2822067, 'BBGlfgwaXu2Na104tdv4');

print "Testing http api..\n";
$vk->switchToHttp();
$data1 = $vk->api('wall.get', array(
    'owner_id' => 1,    // Pavel Durov | Wall
    'count' => 2        // Limit posts
));
print_r($data1);

print "---\n";

print "Testing ssl api, requesting same method..\n";
$vk->switchToSsl();
$data2 = $vk->api('wall.get', array(
    'owner_id' => 1,    // Pavel Durov | Wall
    'count' => 2        // Limit posts
));
print_r($data2);

print "---\n";

print "Comparing results...Is same? > " . (count(array_diff($data1, $data2)) === 0 ? 'yes' : 'no');

if(!$isCli) {
    print "</pre>";
}