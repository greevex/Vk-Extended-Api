<?php

namespace vk\fields\attachments;

class video
extends \vk\abstraction\object
{

    private $title = false;
    private $duration = false;

    public function __construct($data)
    {
        $this->id = $data['vid'];
        $this->owner = new \vk\objects\owner($data['owner_id']);
        $this->title = $data['title'];
        $this->duration = $data['duration'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDuration($format = false)
    {
        /**
         * @todo Сделать возможность вывода video.duration в формате времени timespan
         */
        return $this->duration;
    }

}