<?php

namespace vk\fields\attachments;

class poll
extends \vk\abstraction\attachment
{

    private $question = false;

    public function __construct($data)
    {
        if(!isset($data['poll_id'])) {
            return;
        }
        $this->att_type = 'poll';
        $this->id = $data['poll_id'];
        $this->question = $data['question'];
    }

    public function getQuestion()
    {
        return $this->question;
    }

}