<?php
namespace VEA\lib\interfaces;

/**
 * Request interface
 *
 * @author GreeveX <greevex@gmail.com>
 */
interface request
{

    /**
     * Sends request to retreive data by url
     *
     * @param string $url
     * @param array $params
     * @param string $method - GET | POST ...
     *
     * @return string - reponse data
     */
    public function makeRequest($url, $params = array(), $method = 'GET');

    /**
     * Set count seconds before request timed out
     *
     * @param int $seconds
     */
    public function setTimeout($seconds);

    /**
     * Set count seconds before connection timed out
     *
     * @param int $seconds
     */
    public function setConnectTimeout($seconds);

}