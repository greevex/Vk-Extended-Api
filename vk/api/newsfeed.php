<?php

namespace vk\api;

class newsfeed
extends \vk\abstraction\api
{

    public static function _init()
    {
        parent::$classname = 'newsfeed';
    }

    /**
     * Возвращает результаты поиска по статусам.
     *
     * @param string $q Поисковой запрос, по которому необходимо получить результаты.
     * @param string $geocode Идентификатор местоположения, составленный следующим образом: latitude,longitude,radius.
     * @param integer $count количество сообщений, которое необходимо получить (но не более 100)
     * @param integer $offset смещение, необходимое для выборки определенного подмножества сообщений
     * @param integer $start_time время, в формате unixtime, начиная с которого следует получить новости для текущего пользователя.
     * @param integer $end_time время, в формате unixtime, до которого следует получить новости для текущего пользователя
     * @param integer $start_id Строковый id последней полученной записи
     * @param boolean $extended указывается 1 если необходимо получить информацию о пользователе или группе, разместившей запись.
     */
    public static function search()
    {
        $params = array(
            'q',
            'geocode',
            'count',
            'offset',
            'start_time',
            'end_time',
            'start_id',
            'extended'
        );
        $data = self::_exec($params, func_get_args(), __FUNCTION__);
        return new \vk\objects\posts($data, parent::$classname);
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

} newsfeed::_init();