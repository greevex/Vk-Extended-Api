<?php

namespace vk\fields\attachments;

class page
extends \vk\abstraction\attachment
{

    private $title = false;

    public function __construct($data)
    {
        if(!isset($data['pid'])) {
            return;
        }
        $this->att_type = 'page';
        $this->id = $data['pid'];
        $this->owner = new \vk\objects\owner("-{$data['gid']}");
    }

    public function getTitle()
    {
        return $this->title;
    }

}