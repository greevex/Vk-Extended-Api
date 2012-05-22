<?php

namespace vk\fields\attachments;

class photo
extends \vk\abstraction\attachment
{

    public function __construct($data)
    {
        if(!isset($data['pid'])) {
            return;
        }
        $this->att_type = 'photo';
        $this->id = $data['pid'];
        $this->owner = new \vk\objects\owner($data['owner_id']);

        $this->src = $data['src'];
        $this->src_big = $data['src_big'];
    }

}