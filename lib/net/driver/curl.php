<?php

namespace net\driver;

/**
 * Curl driver for HTTP Request class
 *
 * @author GreeveX <greevex@gmail.com>
 */
class curl
implements \net\iRequest
{
    private $curl;

    private $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'net\request v0.2',
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 60,
    );

    public function makeRequest($url, $params = array(), $method = 'GET')
    {
        if($this->curl == null) {
            $this->curl = curl_init();
        }
        if ($params) {
            $params = http_build_query($params);
        }

        switch($method) {
            case 'GET':
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
                $url .= strpos($url, '?') === false ? "?$params" : "&$params";
                break;
            case 'PUT':
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
                break;
            case 'DELETE':
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
                break;
            case 'POST':
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
                break;
        }

        $this->options[CURLOPT_URL] = $url;

        curl_setopt_array($this->curl, $this->options);

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