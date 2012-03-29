<?php
namespace VEA\lib\interfaces;

/**
 * Connection interface
 *
 * @author GreeveX <greevex@gmail.com>
 */
interface connection
{

    /**
     * Call api method with params
     *
     * @param string $method - api method name
     * @param array $params - api method params
     * @param array $api_type - api type constant
     *
     * @return array - api response
     */
    public function api($method, $params = array(), $api_type = null);

    /**
     * Call api method with params over http protocol
     *
     * @param $method - api method name
     * @param array $params - api method params
     *
     * @return array - api response
     */
    public function api_http($method, $params = array());

    /**
     * Call api method with params over ssl protocol
     *
     * @param $method - api method name
     * @param array $params - api method params
     *
     * @return array - api response
     */
    public function api_ssl($method, $params = array());


    /**
     * Set login and password
     * Required to use «client» authorization type
     *
     * @param string $login - login or e-mail
     * @param string $password - password
     */
    public function setLoginAndPassword($login, $password);

    /**
     * Authorization
     *
     * @example
     * server - server-side old authorization
     * server2 - server-side new OAuth2 authorization
     * client - authorize using login and password
     *
     * @param string $type - server|server2|client
     * @return boolean - true on success or false on failure
     */
    public function authorize($type = 'server');

    /**
     * Server-side new authorization using OAuth2
     *
     * @return boolean - true on success or false on failure
     */
    public function authorize_server();

    /**
     * Server-side client authorization using login and password
     * specified on object construct
     *
     * @return boolean - true on success or false on failure
     */
    public function authorize_client();

    /**
     * Validate result for an errors
     *
     * @param Array $result
     */
    public function validate($result);

    /**
     * Switch to api requests throw HTTP protocol
     *
     */
    public function switchToHttp();

    /**
     * Switch to api requests throw SSL protocol
     *
     */
    public function switchToSsl();

    /**
     * Get OAuth2 access token.
     *
     * @return string
     */
    public function getAccessToken();

    /**
     * Set OAuth2 access token.
     *
     * @param string $access_token
     */
    public function setAccessToken($access_token);

    /**
     * Get an object of last error
     *
     * @return \Exception
     */
    public function getLastError();

    /**
     * Get application ID
     *
     * @return integer
     */
    public function getAppId();

    /**
     * Get application secret
     *
     * @return string
     */
    public function getAppSecret();

    /**
     * Set application access level
     * Taken array of access const values
     *
     * @param Array $scope
     */
    public function setScope(Array $scope);

}