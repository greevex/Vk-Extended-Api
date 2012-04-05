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
/*

### Output:

[2012-04-02 14:08:28] | Павел Дуров | Друзья, рассматривается прогрессивный законопроект о запрете курения в общественных местах, давайте поддержим.
Голосование: Как вы относитесь к запрету на курение в общественных местах?
[2012-03-06 00:58:26] | Павел Дуров | Рекорд: за прошедшие сутки на сайт vk.com зашло 35 миллионов человек.
[2012-03-04 20:27:12] | Павел Дуров | Лента радует очередным массовым опросом:
Голосование: За кого вы проголосовали на выборах президента РФ 4 марта 2012 года?

/**/