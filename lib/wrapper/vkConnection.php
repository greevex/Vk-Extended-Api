<?php

namespace VEA\lib\wrapper;

/**
 * vkConnection
 *
 * @author GreeveX <greevex@gmail.com>
 */
class vkConnection
implements \VEA\lib\interfaces\connection
{

    const
            SCOPE_USEREVENTS  = 1,
            SCOPE_FRIENDS     = 2,
            SCOPE_PHOTOS      = 4,
            SCOPE_AUDIO       = 8,
            SCOPE_VIDEOS      = 16,
            SCOPE_PROPOSALS   = 32,
            SCOPE_QUESTIONS   = 64,
            SCOPE_WIKI        = 128,
            SCOPE_LEFTMENU    = 256,
            SCOPE_WALLPOST    = 512,
            SCOPE_STATUSES    = 1024,
            SCOPE_NOTES       = 2048,
            SCOPE_ADV_MESS    = 4096,
            SCOPE_ADV_WALL    = 8192,
            SCOPE_ADVERTISING = 32768,
            SCOPE_DOCUMENTS   = 131072,
            SCOPE_GROUPS      = 262144,

            ATYPE_HTTP  = 100,
            ATYPE_SSL   = 101,

            AFORM_JSON  = 'json',
            AFORM_XML   = 'xml'
    ;

    /**
     *
     * @var \VEA\lib\net\request
     * @see \VEA\lib\interfaces\request
     */
    private $request;

    private $access_token = '';

    protected $login;
    protected $password;

    protected $app_id;
    protected $app_secret;

    public static $api_url = 'http://api.vk.com/api.php';
    public static $sapi_url = 'https://api.vk.com/method/';
    public static $callback_url = 'http://api.vk.com/blank.html';

    protected $scope = 0;

    protected $api_type = self::ATYPE_HTTP;
    protected $api_format = 'json';

    protected $last_error;

    public function __construct($app_id, $app_secret, $api_format = 'json')
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->api_format = $api_format;
        $this->request = new \VEA\lib\net\request();
    }

    public function api($method, $params = Array(), $api_type = null)
    {
        if($api_type == null) {
            $api_type = $this->api_type;
        }
        if($api_type == self::ATYPE_HTTP) {
            return $this->api_http($method, $params);
        } elseif($api_type == self::ATYPE_SSL) {
            return $this->api_ssl($method, $params);
        }
        return false;
    }

    public function api_http($method, $params = Array())
    {
        $params['api_id'] = $this->getAppId();
        $params['v'] = '3.0';
        $params['method'] = $method;
        $params['timestamp'] = time();
        $params['format'] = $this->api_format;
        $params['random'] = microtime(1);
        ksort($params);

        $params['sig'] = $this->makeSignature($params);

        $response = json_decode(
                $this->request->makeRequest(self::$api_url, $params),
                true);
        if(!$this->validate($response)) {
            return false;
        }
        return $response;
    }

    public function api_ssl($method, $params = Array())
    {
        $params['access_token'] = $this->getAccessToken();
        $response = json_decode(
                $this->request->makeRequest(self::$sapi_url . "$method.$this->api_format", $params),
                true);
        if(!$this->validate($response)) {
            return false;
        }
        return $response;
    }

    public function authorize($type = 'server')
    {
        $method = "authorize_{$type}";
        return $this->$method();
    }

    public function authorize_server()
    {
        $params = array(
            'display' => 'page',
            'response_type' => 'code',
            'client_id' => $this->app_id,
            'scope' => $this->scope,
            'redirect_uri' => self::$callback_url
        );
        try {
            $response = $this->request->makeRequest($this->sapi_url, $params);
            $code = trim(striptags($response));
            $access_token = $this->callAccessTokenByCode($code);
            $this->setAccessToken($access_token);
            $this->authorized = true;
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    public function authorize_client()
    {
        $this->authorized = false;
        throw new \Exception("Not working now", -1);
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    public function getAppId()
    {
        return $this->app_id;
    }

    public function getAppSecret()
    {
        return $this->app_secret;
    }

    public function getLastError()
    {
        return $this->last_error;
    }

    public function switchToHttp()
    {
        $this->api_type = self::ATYPE_HTTP;
    }

    public function switchToSsl()
    {
        $this->api_type = self::ATYPE_SSL;
    }

    public function validate($result)
    {
        if(!is_array($result)) {
            return false;
        }
        if(isset($result['error'])) {
            print_r($result);
            $e = new \Exception($result['error']['error_code'], $result['error']['error_code']);
            $this->last_error = $e;
            return false;
        }
        return true;
    }

    public function setScope(Array $scope)
    {
        $scope_int = 0;
        foreach($scope as $scope_item) {
            $scope_int += intval($scope_item);
        }
        $this->scope = $scope_int;
    }

    public function setLoginAndPassword($login, $password)
    {
        $this->login = strval($login);
        $this->password = strval($password);
    }

    private function makeSignature(Array $params)
    {
        $signature = "";
        foreach ($params as $k => $v) {
            $signature .= "$k=$v";
        }
        return md5("$signature$this->app_secret");
    }

    private function callAccessTokenByCode($code)
    {
        $params = array(
            'client_id' => $this->getAppId(),
            'client_secret' => $this->getAppSecret(),
            'code' => $code,
        );

        $response = json_decode(
                $this->request->makeRequest($this->oauth_access_token_url, $params),
                true);
        if(!$this->validate($response)) {
            return false;
        }
        if (isset($response['access_token'])) {
            return $response['access_token'];
        } else {
            $e = new \Exception('Unexpected response', -1);
            $this->last_error = $e;
            return false;
        }
    }
}