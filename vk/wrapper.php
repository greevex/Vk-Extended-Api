<?php

namespace vk;

/**
 * vkWrapper
 *
 * @author GreeveX
 */
class wrapper
extends connection\vkConnection
{

    private static $instance;

    public static function getInstance()
    {
        return self::$instance;
    }

    private $current_api_object = '';
    public function __construct($app_id, $app_secret, $api_format = 'json')
    {
        parent::__construct($app_id, $app_secret, $api_format);
        self::$instance = $this;
    }

    public function __get($class)
    {
        if(!empty($class)) {
            $this->current_api_object = $this->_load_api($class);
            return $this->current_api_object;
        }
        return $this;
    }

    private function _load_api($class)
    {
        $classpath = __DIR__ . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . "{$class}.php";
        $classname = "\\vk\\api\\{$class}";
        if(file_exists($classpath)) {
            require_once $classpath;
            return new $classname();
        }
        return "{$class}.";
    }

    public function __call($method, $params)
    {
        if(is_object($this->current_api_object)) {
            return $this->current_api_object->{$method}($params);
        } else {
            if(isset($params[0])) {
                $params = $params[0];
            }
            $method = "$this->current_api_object$method";
            return $this->api($method, $params);
        }
    }
}