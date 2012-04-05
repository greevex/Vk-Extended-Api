<?php

namespace vk\objects;

class post
extends \vk\abstraction\object
{

    protected $date;
    protected $text;
    protected $comments;
    protected $likes;
    protected $attachments;
    protected $geo;

    public function getGeo()
    {
        return $this->geo;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function getLikes()
    {
        return $this->likes;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getDate($format = false)
    {
        if(!$format) {
            return $this->date;
        }
        return date($format, $this->date);
    }

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->owner = new owner($data);
        if(isset($data['date'])) {
            $this->date = $data['date'];
        }
        $this->text = $data['text'];

        if(isset($data['comments'])) {
            /**
            * @todo $this->comments = new comments($data['comments']);
            */
            $this->comments = (object)$data['comments'];
        }

        if(isset($data['likes'])) {
            $this->likes = (object)$data['likes'];
        }

        if(isset($data['attachments'])) {
            $this->attachments = new \vk\fields\attachments($data['attachments']);
        } else {
            $this->attachments = array();
        }
        if(isset($data['geo'])) {
            /**
            * $this->geo = new geo($data['geo']);
            */
            $this->geo = $data['geo'];
        }
    }
}