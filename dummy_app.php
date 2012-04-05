<?php

use vk\api\newsfeed;
use vk\api\wall;

require __DIR__ . '/vk_extended_api.al.php';

new \vk\wrapper(2822067, 'BBGlfgwaXu2Na104tdv4');

//$posts = newsfeed::search(array('q' => 'test', 'count' => 100, 'extended' => 1));
$posts = wall::get(array('owner_id' => '1', 'count' => 3, 'extended' => 1));

foreach($posts as $post)
{
    echo
    $post->getDate("[Y-m-d H:i:s] | "), $post->getOwner()->getName(), " | ", $post->getText(), "\n";
    foreach($post->getAttachments() as $attachment) {
        if($attachment->getAttType() == 'poll') {
            print "Голосование: {$attachment->getQuestion()}\n";
        }
    }
}