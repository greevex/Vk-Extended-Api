<?php

namespace vk\abstraction;

abstract class api
{

    protected static $classname;

    /**
     * vkConnection
     *
     * @return \vk\connection\vkConnection
     */
    protected static function api()
    {
        return \vk\wrapper::getInstance();
    }

    public function __toString()
    {
        return $this->classname;
    }

    protected static function _exec($keys, $params, $function)
    {
        if(isset($params[0]) && is_array($params[0])) {
            $params = $params[0];
        } else {
            $params = self::combineArgs($keys, $params);
        }
        return self::api()->api(self::$classname . "." . $function, $params);
    }

    protected static function combineArgs($params, $args)
    {
        $result = array();
        for($i = 0; $i < count($params); $i++) {
            if(!isset($args[$i])) {
                break;
            }
            $result[$params[$i]] = $args[$i];
        }
        return $result;
    }
}