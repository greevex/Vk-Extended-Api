<?php
require __DIR__ . '/vk_extended_api.al.php';

$vk = new \vk\wrapper(2822067, 'BBGlfgwaXu2Na104tdv4');

$vk->setVerbose(false);
$data = $vk->wall->get(array('owner_id' => 1, 'count' => 2));
var_dump($data);
$data = $vk->getServerTime();
var_dump($data);die();
echo "Start time: ", date("Y-m-d H:i:s", $start_time), "\n\n";
foreach($data as $post)
{
    if(is_int($post)) {
        continue;
    }
    echo date("[Y-m-d H:i:s] ", $post['date']),
            (isset($post['user']) ? $post['user']['screen_name'] : $post['group']['screen_name']),
            " | ", $post['text'], "\n";
}