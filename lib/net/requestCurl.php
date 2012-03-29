<?php

namespace VEA\lib\net;

/**
 *
 *
 * @author GreeveX <greevex@gmail.com>
 */
class requestCurl
extends requestBase
implements \VEA\lib\interfaces\request
{
    private $curl;

    private $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Vk-Extended-Api v1.1',
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 60,
    );

    public function makeRequest($url, $params = array(), $method = 'GET')
    {
        if ($params) {
            $params = http_build_query($params);
        }

        if($this->curl == null) {
            $this->curl = curl_init();
        }
        curl_setopt_array($this->curl, $this->options);

        switch($method) {
            case 'GET':
                $url .= strpos($url, '?') === false ? "?$params" : "&$params";
                break;
            case 'POST':
                curl_setopt($this->curl, CURLOPT_POST, true);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
                break;
        }

        $this->options[CURLOPT_URL] = $url;

        $result = curl_exec($this->curl);

        $curl_errno = curl_errno($this->curl);

        if ($curl_errno != CURLE_OK) {
            $curl_error = curl_error($this->curl);
            curl_close($this->curl);
            $this->curl = null;
            throw new \Exception($curl_error, $curl_errno);
        }

        return $result;
    }

    public function setConnectTimeout($seconds)
    {
        $this->options[CURLOPT_CONNECTTIMEOUT] = intval($seconds);
    }

    public function setTimeout($seconds)
    {
        $this->options[CURLOPT_TIMEOUT] = intval($seconds);
    }
}