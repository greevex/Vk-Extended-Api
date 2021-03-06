<?php

namespace vk\fields\attachments;

class app
extends \vk\abstraction\attachment
{

    private $name = false;
    private $src = false;
    private $src_big = false;

    public function __construct($data)
    {
        if(!isset($data['app_id'])) {
            return;
        }
        $this->att_type = 'app';
        $this->id = $data['app_id'];
        $this->name = $data['app_name'];
        $this->src = $data['src'];
        $this->src_big = $data['src_big'];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSrc()
    {
        return $this->src;
    }

    public function getSrcBig()
    {
        return $this->src_big;
    }

}