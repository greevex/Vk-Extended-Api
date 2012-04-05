<?php

namespace vk\fields\attachments;

class link
extends \vk\abstraction\object
{

    private $url = false;
    private $title = false;
    private $description = false;
    private $image_src = false;

    public function link($data)
    {
        $this->url = $data['url'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->image_src = isset($data['image_src']) ? $data['image_src'] : false;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImageSrc()
    {
        return $this->image_src;
    }

}