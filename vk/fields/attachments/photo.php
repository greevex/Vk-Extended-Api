<?php

namespace vk\fields\attachments;

class photo
extends \vk\abstraction\image
{

    public function photo($data)
    {
        $this->id = $data['pid'];
        $this->owner = new \vk\objects\owner($data['owner_id']);

        $this->src = $data['src'];
        $this->src_big = $data['src_big'];
    }

}