<?php

namespace vk\abstraction;

abstract class image
extends object
{

    private $src;
    private $src_big;
    
    /**
     * Возвращает адрес изображения
     * Если передан параметр true, то вернет адрес изображения большого размера
     * Стандартно возвращает адрес изображения маленького размера
     *
     * @param boolean $big
     * @return string Адрес изображения
     */
    public function getSrc($big = false)
    {
        return $big ? $this->src_big : $this->src;
    }

}