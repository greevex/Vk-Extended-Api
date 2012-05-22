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
        CURLOPT_FOLLOWLOCATION => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Lynx/2.8.6rel.4 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.8g',
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_TIMEOUT => 60,
    );

    public function makeRequest($url, $params = array(), $method = 'GET')
    {
        if($this->curl == null) {
            $this->curl = curl_init();
            $filename = md5(__CLASS__) . ".txt";
            curl_setopt($this->curl, CURLOPT_COOKIEFILE, sys_get_temp_dir() . "/$filename");
            curl_setopt($this ->curl, CURLOPT_COOKIEJAR, sys_get_temp_dir() . "/$filename");
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

    public function getBackend()
    {
        return $this->curl;
    }
}