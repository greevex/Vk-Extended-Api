<?php

namespace vk\objects;

class posts
extends \ArrayObject
{
    public function __construct($data)
    {
        foreach($data as $post)
        {
            if(!is_array($post)) {
                continue;
            }
            $posts[] = new post($post);
        }
        parent::__construct($posts);
    }
}