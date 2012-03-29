<?php

namespace VEA\lib\net;

/**
 * Request class abstraction
 *
 * @author GreeveX <greevex@gmail.com>
 */
class requestBase
implements \VEA\lib\interfaces\request
{
    protected $instance;

    /**
     * Will load driver on constructing
     *
     * @param string $driver - only curl at this moment
     */
    public function __construct($driver = 'curl')
    {
        $classname = "request" . ucfirst($driver);
        require __DIR__ . DIRECTORY_SEPARATOR . "$classname.php";
        $this->instance = new $classname();
    }

    public function makeRequest($url, $params = array(), $method = 'GET')
    {
        return $this->instance->makeRequest($url, $params, $method);
    }

    public function setConnectTimeout($seconds)
    {
        return $this->instance->setConnectTimeout($seconds);
    }

    public function setTimeout($seconds)
    {
        return $this->instance->setTimeout($seconds);
    }
}