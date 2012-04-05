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
    private $current_api_object = '';
    public function __construct($app_id, $app_secret, $api_format = 'json')
    {
        parent::__construct($app_id, $app_secret, $api_format);
    }

    public function __get($parameter)
    {
        $this->current_api_object = $parameter;
        if(!empty($parameter)) {
            $this->current_api_object .= ".";
        }
        return $this;
    }

    public function __call($method, $params)
    {
        if(isset($params[0])) {
            $params = $params[0];
        }
        $method = "$this->current_api_object$method";
        $this->current_api_object = '';
        return $this->api($method, $params);
    }
}