<?php

namespace net;

/**
 * Request interface
 *
 * @author GreeveX <greevex@gmail.com>
 */
interface iRequest
{

    /**
     * Make request to http host
     *
     * @param string $url
     * @param array $params HTTP-request params
     * @param string $method HTTP-Method ( GET | POST | PUT | DELETE )
     * @return string Host answer
     */
    public function makeRequest($url, $params = array(), $method = 'GET');

    /**
     * Set request timeout in seconds
     *
     * @param integer $seconds
     */
    public function setTimeout($seconds);

    /**
     * Set connect timeout in seconds
     *
     * @param integer $seconds
     */
    public function setConnectTimeout($seconds);

}