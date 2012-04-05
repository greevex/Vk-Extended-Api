<?php

namespace vk\objects;

class owner
extends \vk\abstraction\object
{

    private $name;
    private $screen_name;
    private $photo;
    private $photo_med;


    public function getName()
    {
        return $this->name;
    }

    public function getScreenName()
    {
        return $this->screen_name;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getPhotoMed()
    {
        return $this->photo_med;
    }

    public function __construct($data, $extended = false)
    {
        if(!is_array($data)) {
            if($extended) {
                $this->getInfo($data);
            } else {
                $this->id = $data;
            }
        } else {
            if(!isset($data['owner_id'], $data['from_id'])) {
                if(isset($data['uid'])) {
                    $this->parseUser($data);
                } elseif(isset($data['gid'])) {
                    $this->parseGroup($data);
                }
            } else {
                $this->parse($data);
            }
        }
    }

    private function parse($data)
    {
        if(isset($data['owner_id'])) {
            $owner = $data['owner_id'];
        } elseif(isset($data['from_id'])) {
            $owner = $data['from_id'];
        }
        if(mb_substr($owner, 0 ,1) == '-') {
            if(isset($data['group'])) {
                return $this->parseGroup($data['group']);
            }
        } else {
            if(isset($data['user'])) {
                return $this->parseUser($data['user']);
            }
        }
        return false;
    }

    private function parseUser($data)
    {
        $this->id = $data['uid'];
        $this->name = "{$data['first_name']} {$data['last_name']}";
        if(isset($data['screen_name'])) {
            $this->screen_name = $data['screen_name'];
        }
        $this->photo = $data['photo'];
        $this->photo_med = $data['photo_medium_rec'];
    }

    private function parseGroup($data)
    {
        $this->id = "-{$data['gid']}";
        $this->name = $data['name'];
        $this->screen_name = $data['screen_name'];
        $this->photo = $data['photo'];
        $this->photo_med = $data['photo_medium'];
    }

    public function getInfo($data)
    {

    }

}