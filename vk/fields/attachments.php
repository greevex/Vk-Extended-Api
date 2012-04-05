<?php

namespace vk\fields;

class attachments
{

    private $objects = array();

    private $att_type = array(
        'photo' => 'photo',
        'posted_photo' => 'posted_photo',
        'video' => 'video',
        'audio' => 'audio',
        'doc' => 'doc',
        'graffiti' => 'graffiti',
        'link' => 'link',
        'note' => 'note',
        'app' => 'app',
        'poll' => 'poll',
        'page' => 'page'
    );

    public function attachments($attachments)
    {
        foreach($attachments as $attachment) {
            if(!isset($this->att_type[$attachment['type']])) {
                continue;
            }
            $type = $this->att_type[$attachment['type']];
            $attachment_class = "\\vk\\fields\\attachments\\{$type}";
            $this->objects[] = new $attachment_class($attachment[$attachment['type']]);
        }
    }

    public function getObjects()
    {
        return $this->objects;
    }

}