<?php

namespace net;

/**
 * HTTP Request class
 *
 * @author GreeveX <greevex@gmail.com>
 */
class request
implements iRequest
{
    protected $instance;

    /**
     * Loading driver
     *
     * @param string $driver - curl | httprequest
     */
    public function __construct($driver = 'curl')
    {
        require_once __DIR__ .
                DIRECTORY_SEPARATOR . "driver" . DIRECTORY_SEPARATOR . "{$driver}.php";
        $classname = __NAMESPACE__ . "\\driver\\{$driver}";
        $this->instance = new $classname();
    }

    public function getBackend()
    {
        return $this->instance;
    }

    public function makeRequest($url, $params = array(), $method = 'GET')
    {
        return $this->instance->makeRequest($url, $params, $method);
    }

    public function setConnectTimeout($seconds)
    {
        $this->instance->setConnectTimeout($seconds);
    }

    public function setTimeout($seconds)
    {
        $this->instance->setTimeout($seconds);
    }
}