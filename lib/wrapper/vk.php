<?php

namespace VEA\lib\wrapper;

/**
 * vkWrapper
 *
 * @author GreeveX
 */
class vk
extends vkConnection
{
    public function __construct($app_id, $app_secret, $api_format = 'json')
    {
        parent::__construct($app_id, $app_secret, $api_format);
    }
}