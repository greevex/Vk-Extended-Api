<?php

namespace vk\objects;

class posts
extends \ArrayObject
{
    public function __construct($data, $type = 'newsfeed')
    {
        $method = "import" . ucfirst($type);
        $posts = $this->{$method}($data);
        parent::__construct($posts);
    }

    private function importWall($data)
    {
        $owners = array();

        foreach($data['profiles'] as $profile) {
            $owners[$profile['uid']] = $profile;
        }
        foreach($data['groups'] as $group) {
            $owners["-{$group['gid']}"] = $group;
        }
        foreach($data['wall'] as $key => $post) {
            if(isset($post['owner_id'])) {
                if(mb_substr($post['owner_id'], 0, 1) == '-') {
                    $owner_key = 'group';
                } else {
                    $owner_key = 'user';
                }
                $data['wall'][$key][$owner_key] = $owners[$post['owner_id']];
            } elseif(isset($post['from_id'])) {
                if(mb_substr($post['from_id'], 0, 1) == '-') {
                    $owner_key = 'group';
                } else {
                    $owner_key = 'user';
                }
                $data['wall'][$key]['owner_id'] = $post['from_id'];
                $data['wall'][$key][$owner_key] = $owners[$post['from_id']];
            }
        }

        $posts = array();
        foreach($data['wall'] as $post)
        {
            if(!is_array($post)) {
                continue;
            }
            $posts[] = new post($post);
        }
        return $posts;
    }

    private function importNewsfeed($data)
    {
        $posts = array();
        foreach($data as $post)
        {
            if(!is_array($post)) {
                continue;
            }
            $posts[] = new post($post);
        }
        return $posts;
    }
}