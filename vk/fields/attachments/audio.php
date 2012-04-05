<?php

namespace vk\fields\attachments;

class audio
extends \vk\abstraction\object
{

    private $title = false;
    private $duration = false;
    private $performer = false;

    public function audio($data)
    {
        $this->id = $data['aid'];
        $this->owner = new \vk\objects\owner($data['owner_id']);
        $this->title = $data['title'];
        $this->duration = $data['duration'];
        $this->performer = $data['performer'];
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

    public function getPerformer()
    {
        return $this->performer;
    }

}