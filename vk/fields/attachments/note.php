<?php

namespace vk\fields\attachments;

class note
extends \vk\abstraction\attachment
{

    private $title = false;
    private $ncom = false;

    public function __construct($data)
    {
        if(!isset($data['nid'])) {
            return;
        }
        $this->att_type = 'note';
        $this->id = $data['nid'];
        $this->owner_id = new \vk\objects\owner($data['owner_id']);
        $this->title = $data['title'];
        $this->ncom = $data['ncom'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getNcom()
    {
        return $this->image_src;
    }

    public function getCommentsCount()
    {
        return $this->getNcom();
    }

}