<?php

namespace vk\fields\attachments;

class poll
extends \vk\abstraction\object
{

    private $question = false;

    public function __construct($data)
    {
        $this->id = $data['poll_id'];
        $this->question = $data['question'];
    }

    public function getQuestion()
    {
        return $this->name;
    }

}