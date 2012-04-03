<?php

namespace net;

require __DIR__ . DIRECTORY_SEPARATOR . 'iRequest.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'request.php';

/**
 * HTTP-Client class
 *
 * @author GreeveX <greevex@gmail.com>
 */
class Client {

    private $uri;

    private $method;

    private $params = array();

    private $backend;

    /**
     * Конструктор.
     * Входящим параметром можно указать драйвер, через который будут осуществляться запросы
     *
     * @param string $driver curl | httprequest
     */
    public function __construct($driver = 'curl')
    {
        $this->backend = new \net\request(strtolower($driver));
    }

    /**
     * Сбрасывает все установленные значения.
     * Если передан параметр true, то инициализирует новый объект для http-запросов
     *
     * @param bool $full
     */
    public function reset($full = false)
    {
        if($full) {
            $this->backend = new \net\request($driver);
        }
        $this->uri = "";
        $this->method = "";
        $this->params = array();
    }

    /**
     * Устанавливает URI, на который будет производиться http-запрос
     *
     * @param string $uri
     * @throws \Exception
     */
    public function setUri($uri)
    {
        if(function_exists('http_build_url')) {
            $uri = http_build_url($uri);
        }
        if(!$uri) {
            throw new \Exception("Bad URI in " . __METHOD__, -1);
        }
        $this->uri = $uri;
    }

    /**
     * Устанавливает параметры, которые следует передать в http-запросе
     *
     * @param array $input
     */
    public function setParams(array $input)
    {
        $this->params = array_merge($this->params, $input);
    }

    /**
     * Устанавливает http-метод, которым нужно выполнить запрос
     * Разрешенные методы: POST GET PUT DELETE
     *
     * @param type $method
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    /**
     * Выполняет http-запрос с указанными параметрами
     *
     * @return string
     */
    public function send()
    {
        return $this->backend->makeRequest($this->uri, $this->params, $this->method);
    }

}