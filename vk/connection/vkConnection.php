<?php

namespace vk\connection;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'net' . DIRECTORY_SEPARATOR . 'Client.php';

/**
 * vkConnection
 *
 * @author GreeveX <greevex@gmail.com>
 */
class vkConnection
implements iConnection
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

    private $string_scope = array(
        self::SCOPE_FRIENDS     => 'friends',
        self::SCOPE_PHOTOS      => 'photos',
        self::SCOPE_AUDIO       => 'audio',
        self::SCOPE_VIDEOS      => 'video',
        self::SCOPE_QUESTIONS   => 'questions',
        self::SCOPE_WIKI        => 'pages',
        self::SCOPE_NOTES       => 'notes',
        self::SCOPE_ADV_MESS    => 'messages',
        self::SCOPE_ADV_WALL    => 'wall',
        self::SCOPE_ADVERTISING => 'ads',
        self::SCOPE_DOCUMENTS   => 'docs',
        self::SCOPE_GROUPS      => 'groups',
    );

    /**
     *
     * @var \VEA\lib\net\request
     * @see \VEA\lib\interfaces\request
     */
    private $request;

    private $access_token = '';

    protected $login = '';
    protected $password = '';

    protected $app_id = '';
    protected $app_secret = '';

    protected $api_url = 'http://api.vk.com/api.php';
    protected $sapi_url = 'https://api.vk.com/method/';
    protected $callback_url = 'http://api.vk.com/blank.html';
    protected $oauth_auth_url = 'http://oauth.vk.com/authorize';
    protected $api_oauth_auth_url = 'http://api.vk.com/oauth/authorize';
    protected $oauth_access_token_url = 'https://oauth.vk.com/access_token';
    protected $client_login_url = 'https://login.vk.com/?act=login&soft=1&utf8=1';

    protected $scope = 0;

    protected $api_type = self::ATYPE_HTTP;
    protected $api_format = 'json';

    protected $authorization_method = 'client';

    protected $last_error;

    protected $verbose = true;

    public function setVerbose($state)
    {
        $this->verbose = $state;
    }

    public function __construct($app_id = null, $app_secret = null, $api_format = 'json')
    {
        if($app_id != null && $app_secret != null) {
            $this->app_id = $app_id;
            $this->app_secret = $app_secret;
        }
        $this->api_format = $api_format;
        $this->request = new \net\request();
        $this->string_scope = array(
            self::SCOPE_FRIENDS     => 'friends',
            self::SCOPE_PHOTOS      => 'photos',
            self::SCOPE_AUDIO       => 'audio',
            self::SCOPE_VIDEOS      => 'video',
            self::SCOPE_QUESTIONS   => 'questions',
            self::SCOPE_WIKI        => 'pages',
            self::SCOPE_NOTES       => 'notes',
            self::SCOPE_ADV_MESS    => 'messages',
            self::SCOPE_ADV_WALL    => 'wall',
            self::SCOPE_ADVERTISING => 'ads',
            self::SCOPE_DOCUMENTS   => 'docs',
            self::SCOPE_GROUPS      => 'groups',
        );
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

        $response = $this->request->makeRequest($this->api_url, $params);
        if(!$this->validate($response)) {
            return false;
        }
        if($this->verbose) {
            $response = $response['response'];
        }
        return $response;
    }

    public function api_ssl($method, $params = Array())
    {
        $params['access_token'] = $this->getAccessToken();
        $response = $this->request
                ->makeRequest($this->sapi_url . "$method.$this->api_format", $params);
        if(!$this->validate($response)) {
            return false;
        }
        if($this->verbose) {
            $response = $response['response'];
        }
        return $response;
    }

    public function authorize($type = 'server')
    {
        $this->authorization_method = $type;
        $method = "authorize_{$this->authorization_method}";
        return $this->$method();
    }

    public function authorize_server()
    {

        $access_token = $this->callAccessTokenByClientCredentials();
        $this->setAccessToken($access_token);
        $this->authorized = true;
        return true;
    }

    public function authorize_client()
    {
        $params = array(
            'client_id' => $this->getAppId(),
            'scope' => $this->getScope(true),
            'redirect_uri' => $this->callback_url,
            'display' => 'wap',
            'response_type' => 'token',
        );
        $response = $this->request->makeRequest($this->oauth_auth_url, $params);
        $real_url = curl_getinfo($this->request->getBackend()->getBackend(), CURLINFO_EFFECTIVE_URL);
        if(strpos($real_url, 'token=') != false) {
            $this->getCodeFromUri($real_url);
            return true;
        }
        \grunge\system\service\fileLoader::load('/libs/phpQuery/phpQuery/phpQuery');
        $tidy = new \tidy;
        $config = array(
            'indent'         => true,
            'output-xhtml'   => true,
            'wrap'           => 200
        );
        $tidy->parseString($response, $config, 'utf8');
        $tidy->cleanRepair();
        $response = (string)$tidy;
        $doc = \phpQuery::newDocument($response);
        $params = array();
        foreach($doc['form input'] as $input) {
            $key = $input->getAttribute('name');
            if(empty($key)) {
                continue;
            }
            $params[$key] = pq($input)->val();
        }
        $params['email'] = $this->login;
        $params['pass'] = $this->password;
        $action = pq($doc['form'])->attr('action');
        $response = $this->request->makeRequest($action, $params, 'POST');
        $real_url = curl_getinfo($this->request->getBackend()->getBackend(), CURLINFO_EFFECTIVE_URL);
        $response = $this->request->makeRequest($real_url, null, 'GET');
        $real_url = curl_getinfo($this->request->getBackend()->getBackend(), CURLINFO_EFFECTIVE_URL);
        die($response.$real_url);
        if(strpos($real_url, 'token=') != false) {
            $this->getCodeFromUri($real_url);
            return true;
        }

        $tidy = new \tidy;
        $config = array(
            'indent'         => true,
            'output-xhtml'   => true,
            'wrap'           => 200
        );
        $tidy->parseString($response, $config, 'utf8');
        $tidy->cleanRepair();
        $response = (string)$tidy;
        $doc = \phpQuery::newDocument($response);
        $action = pq($doc['form'])->attr('action');
        $response = $this->request->makeRequest($action, array(), 'POST');
        $real_url = curl_getinfo($this->request->getBackend()->getBackend(), CURLINFO_EFFECTIVE_URL);
        $this->getCodeFromUri($real_url);
        return true;
    }

    protected function getCodeFromUri($uri)
    {
        $split = 'token=';
        $code = mb_substr($uri, mb_strpos($uri, $split) + mb_strlen($split));
        $time = time()+43200;
        $amp = mb_strpos($code, '&');
        if($amp) {
            $code = mb_substr($code, 0, mb_strpos($code, '&'));
            $split = 'expires_in=';
            $time = mb_substr($uri, mb_strpos($uri, $split) + mb_strlen($split));
            $amp = mb_strpos($time, '&');
            if($amp) {
                $time = mb_substr($time, 0, $amp);
            }
        }
        $this->setAccessToken($code, intval($time));
    }

    public function getScope($string = false)
    {
        if($string) {
            $scope_str = array();
            foreach($this->string_scope as $key => $value) {
                if($this->scope&$key) {
                    $scope_str[] = $value;
                }
            }
            return implode(',', $scope_str);
        } else {
            return $this->scope;
        }
    }

    public function getAccessToken()
    {
        $cache = \grunge\system\cache\cache::factory();
        $key = md5("vk_token_" . $this->getAppId());
        if($cache->exists($key)) {
            $key_data = $cache->get($key);
            if($key_data['time'] >= $key_data['access_token']) {
                $this->access_token = $key_data['access_token'];
            } else {
                $this->authorize($this->authorization_method);
            }
        } else {
            $this->authorize($this->authorization_method);
        }
        return $this->access_token;
    }

    public function setAccessToken($access_token, $time = null)
    {
        if($time == null) {
            $time = time()+43200;
        }
        $key_data = array(
            'access_token' => $access_token,
            'time' => $time
        );
        $cache = \grunge\system\cache\cache::factory();
        $key = md5("vk_token_" . $this->getAppId());
        $cache->set($key, $key_data);
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

    public function validate(&$result)
    {
        if(!is_array($result)) {
            $result = json_decode($result, true);
        }
        if(!is_array($result)) {
            return false;
        }
        if(isset($result['error'])) {
            $e = new \Exception($result['error']['error_msg']);
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

        $response = $this->request->makeRequest($this->oauth_access_token_url, $params);
        if(!$this->validate($response)) {
            return false;
        }
        if (!isset($response['access_token'])) {
            return $this->forceUnexpected();
        }
        return $response['access_token'];
    }

    private function forceUnexpected()
    {
        $e = new \Exception('Unexpected response', -1);
        $this->last_error = $e;
        return false;
    }

    private function callAccessTokenByClientCredentials()
    {
        $params = array(
            'client_id' => $this->getAppId(),
            'client_secret' => $this->getAppSecret(),
            'grant_type' => 'client_credentials',

        );
        $response = $this->request->makeRequest($this->oauth_access_token_url, $params);
        if(!$this->validate($response)) {
            return false;
        }
        if(!isset($response['access_token'])) {
            return $this->forceUnexpected();
        }
        return $response['access_token'];
    }

    public function loadConfig($data)
    {
        if(!is_array($data)) {
            return false;
        }
        foreach($data as $key => $value)
        {
            if(isset($this->$key)) {
                $this->$key = $value;
            }
        }
        return true;
    }

    public function setAuthorizationMethod($authorization_method)
    {
        $this->authorization_method = $authorization_method;
        $this->getAccessToken();
    }
}