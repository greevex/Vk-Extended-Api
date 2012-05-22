<?php

namespace vk\fields\attachments;

class doc
extends \vk\abstraction\attachment
{

    private $title = false;
    private $size = false;
    private $ext = false;

    public function __construct($data)
    {
        if(!isset($data['did'])) {
            return;
        }
        $this->att_type = 'doc';
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