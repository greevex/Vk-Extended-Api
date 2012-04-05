<?php

namespace vk\api;

class wall
extends \vk\abstraction\api
{

    protected static $classname = 'wall';

    /**
     * Возвращает список записей со стены пользователя.
     *
     * @param \vk\objects\owner|integer $owner_id идентификатор пользователя.
     * @param integer $offset смещение, необходимое для выборки определенного подмножества сообщений
     * @param integer $count количество сообщений, которое необходимо получить (но не более 100)
     * @param string $filter определяет, какие типы сообщений на стене необходимо получить.
     * @param boolean $extended true - будут возвращены три массива wall, profiles, и groups. По умолчанию дополнительные поля не возвращаются
     */
    public static function get()
    {
        $params = array(
            'owner_id',
            'offset',
            'count',
            'filter',
            'extended'
        );
        $params = self::combineArgs($params, func_get_args());
        $data = self::api()->api(self::$classname . "." . __FUNCTION__, $params);
        return $data;
    }

    public static function getComments()
    {
    }

    public static function getById()
    {
    }

    public static function post()
    {
    }

}