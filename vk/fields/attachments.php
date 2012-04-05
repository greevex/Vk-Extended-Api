<?php

namespace vk\fields;

class attachments
extends \ArrayObject
{

    public function __construct($attachments)
    {
        $objects = array();
        foreach($attachments as $attachment) {
            if(!is_array($attachment)) {
                continue;
            }
            $attachment_class = "\\vk\\fields\\attachments\\{$attachment['type']}";
            try {
                $objects[] = new $attachment_class($attachment[$attachment['type']]);
            } catch(Exception $e) {
                throw new \Exception("Attachment type {$attachment['type']} not implemented!", -1);
            }
        }
        parent::__construct($objects);
    }
}