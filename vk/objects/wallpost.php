<?php

namespace vk\objects;

class wallpost
extends \vk\abstraction\object
{

    private $to;
    private $date;
    private $text;
    private $comments;
    private $likes;
    private $reposts;
    private $attachments;
    private $geo;
    private $signer_id;
    private $copy;

    public function getTo()
    {
        return $this->to;
    }

    public function getCopy()
    {
        return $this->copy;
    }

    public function getReposts()
    {
        return $this->reposts;
    }

    public function getSignerId()
    {
        return $this->signer_id;
    }

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
        var_dump($data);
        $this->id = $data['id'];
        $this->owner = new owner($data);
        $this->to = new owner($data['to_id']);
        $this->date = $data['date'];
        $this->text = $data['text'];

        /**
         * @todo $this->comments = new comments($data['comments']);
         */
        $this->comments = (object)$data['comments'];

        $this->likes = (object)$data['likes'];
        $this->reposts = (object)$data['reposts'];
        $this->signer_id = (object)$data['signer_id'];
        $this->copy = new post(array(
            'text' => $data['copy_text'],
            'owner_id' => $data['copy_owner_id'],
            'id' => $data['copy_post_id']
        ));

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