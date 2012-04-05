<?php

namespace vk\abstraction;

abstract class object
{

    protected $id = false;

    protected $owner = false;

    /**
     * Идентификатор
     *
     * @return string|int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Идентификатор владельца
     * Может содержать пользователя или группу
     *
     * @return \vk\objects\owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    public function getStdStringId()
    {
        return "{$this->owner_id}_{$this->id}";
    }

    public function __toString()
    {
        return $this->id;
    }

}