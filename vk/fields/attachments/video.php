<?php

namespace vk\fields\attachments;

class video
extends \vk\abstraction\attachment
{

    private $title = false;
    private $duration = false;

    public function __construct($data)
    {
        if(!isset($data['vid'])) {
            return;
        }
        $this->att_type = 'video';
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