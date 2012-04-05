<?php

namespace vk\fields\attachments;

class graffiti
extends \vk\abstraction\image
{

    public function __construct($data)
    {
        $this->id = $data['gid'];
        $this->owner = new \vk\objects\owner($data['owner_id']);

        $this->src = $data['src'];
        $this->src_big = $data['src_big'];
    }

}