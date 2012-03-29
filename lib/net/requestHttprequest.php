<?php

namespace VEA\lib\net;

/**
 *
 *
 * @author GreeveX <greevex@gmail.com>
 */
class requestHttprequest
implements \VEA\lib\interfaces\request
{
    /**
     *
     * @see \HttpRequest
     * @var \HttpRequest
     */
    private $httprequest;

    private $options = array(
        'redirect' => 1,
        'verifypeer' => false,
        'useragent' => 'Vk-Extended-Api v1.1',
        'connecttimeout' => 10,
        'timeout' => 60,
    );

    public function makeRequest($url, $params = array(), $method = 'GET')
    {
        if($this->httprequest == null) {
            $this->httprequest = new \HttpRequest();
        }
        if ($params) {
            $params = http_build_query($params);
        }

        switch($method) {
            case 'GET':
                $url .= strpos($url, '?') === false ? "?$params" : "&$params";
                break;
            case 'POST':
                $this->httprequest->setPostFields($params);
                break;
        }

        $this->httprequest->setUrl($url);
        
        $this->httprequest->setOptions($this->options);
        $this->httprequest->setMethod($method);

        return $this->httprequest->send();
    }

    public function setConnectTimeout($seconds)
    {
        $this->httprequest['connecttimeout'] = $seconds;
    }

    public function setTimeout($seconds)
    {
        $this->httprequest['timeout'] = $seconds;
    }
}