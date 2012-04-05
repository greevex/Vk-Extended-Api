<?php

namespace vk\fields\attachments;

class doc
extends \vk\abstraction\object
{

    private $title = false;
    private $size = false;
    private $ext = false;

    public function doc($data)
    {
        $this->id = $data['did'];
        $this->owner = new \vk\objects\owner($data['owner_id']);
        $this->title = $data['title'];
        $this->size = $data['size'];
        $this->ext = $data['ext'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSize($format = false)
    {
        /**
         * @todo Сделать возможность вывода doc.size в форматах
         */
        return $this->size;
    }

    public function getExt()
    {
        return $this->ext;
    }

}