<?php

namespace vk\fields\attachments;

class page
extends \vk\abstraction\object
{

    private $title = false;

    public function page($data)
    {
        $this->id = $data['pid'];
        $this->owner = new \vk\objects\owner("-{$data['gid']}");
    }

    public function getTitle()
    {
        return $this->title;
    }

}