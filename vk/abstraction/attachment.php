<?php

namespace vk\abstraction;

abstract class attachment
extends object
{
    protected $att_type = '';

    public function getAttType()
    {
        return $this->att_type;
    }
}