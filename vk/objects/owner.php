<?php

namespace vk\objects;

class owner
extends \vk\abstraction\object
{

    public function owner($data)
    {
        if(!is_array($data)) {
            $this->id = $data;
        } else {
            $this->parse($data);
        }
    }

    private function parseUser($data)
    {

    }

    private function parseGroup($data)
    {

    }

    private function parse($data)
    {

    }

}