<?php

namespace vk\fields\attachments;

class graffiti
extends \vk\abstraction\attachment
{

    public function __construct($data)
    {
        $this->att_type = 'graffiti';
        $this->id = $data['gid'];
        $this->owner = new \vk\objects\owner($data['owner_id']);

        $this->src = $data['src'];
        $this->src_big = $data['src_big'];
    }

}