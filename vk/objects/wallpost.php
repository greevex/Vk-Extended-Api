<?php

namespace vk\objects;

class wallpost
extends post
{

    protected $to;
    protected $reposts;
    protected $signer_id;
    protected $copy;

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

    public function __construct($data)
    {
        parent::__construct($data);

        $this->to = new owner($data['to_id']);
        $this->reposts = (object)$data['reposts'];
        if(isset($data['signer_id'])) {
            $this->signer_id = (object)$data['signer_id'];
        }
        if(isset($data['copy_text'])) {
            $this->text = $data['copy_text'];
            $this->copy = new post(array(
                'text' => $data['text'],
                'owner_id' => $data['copy_owner_id'],
                'id' => $data['copy_post_id']
            ));
        }
    }
}