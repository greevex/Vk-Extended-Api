<?php

namespace net\driver;

/**
 * HttpRequest driver for HTTP Request class
 *
 * @author GreeveX <greevex@gmail.com>
 */
class httprequest
implements \net\iRequest
{
    /**
     *
     * @var \HttpRequest
     */
    private $httprequest;

    private $options = array(
        'redirect' => 1,
        'verifypeer' => false,
        'useragent' => 'net\request v0.2',
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
                $this->httprequest->setMethod(\HttpRequest::HTTP_METH_GET);
                $url .= strpos($url, '?') === false ? "?$params" : "&$params";
                break;
            case 'PUT':
                $this->httprequest->setMethod(\HttpRequest::HTTP_METH_PUT);
                $this->httprequest->setPutData($params);
                break;
            case 'DELETE':
                $this->httprequest->setMethod(\HttpRequest::HTTP_METH_DELETE);
                $this->httprequest->setPostFields($params);
                break;
            case 'POST':
                $this->httprequest->setMethod(\HttpRequest::HTTP_METH_POST);
                $this->httprequest->setPostFields($params);
                break;
        }

        $this->httprequest->setUrl($url);

        $this->httprequest->setOptions($this->options);

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